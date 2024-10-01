<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Experience;
use App\Models\Attendance;
use App\Models\Attest;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
         // Conta os itens de cada modelo
        $countExperience = Experience::count();
        $countAttendance = Attendance::count();
        $countAttest = Attest::count();

        $totalSalary = Experience::sum('salary');

         // Retorna uma única view com todos os dados
         return view('dashboard', compact(
            'countExperience',
            'countAttendance',
            'countAttest',
            'totalSalary'
        ));
     }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
