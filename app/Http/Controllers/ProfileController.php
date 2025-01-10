<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Employee;
use App\Models\OccurrenceDetail;
use App\Models\DelayDetail;
use App\Models\AttestDetail;
use App\Models\EpiDetail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form and handle salary calculations.
     */
    public function index(Request $request)
    {
        $countEmployee = Employee::count();
        $countAdjuntancy = Employee::distinct('adjuntancy')->count('adjuntancy');
        $countDelay = DelayDetail::count();
        $countAttest = AttestDetail::count();
        $countEpi = EpiDetail::count();
        $countOccurrence = OccurrenceDetail::count();
        $countSalary = Employee::sum('salary');

        $topSalaries = Employee::select('adjuntancy', DB::raw('SUM(salary) as total_salary'))
        ->groupBy('adjuntancy')
        ->orderBy('total_salary', 'desc')
        ->take(5)
        ->get();

        $topAdjuntancys = Employee::select('adjuntancy', DB::raw('count(*) as total'))
        ->groupBy('adjuntancy')
        ->take(5)
        ->get();

        $adjuntancyLabels = $topAdjuntancys->pluck('adjuntancy')->toArray();
        $adjuntancyTotals = $topAdjuntancys->pluck('total')->toArray();

        $admissions = Employee::select(DB::raw('MONTH(admission) as month'), DB::raw('count(*) as total'))
        ->whereYear('admission', '=', now()->year)
        ->groupBy(DB::raw('MONTH(admission)'))
        ->pluck('total', 'month')->toArray();

        $delays = DelayDetail::select(DB::raw('MONTH(delay_date) as month'), DB::raw('count(*) as total'))
        ->whereYear('delay_date', '=', now()->year)
        ->groupBy(DB::raw('MONTH(delay_date)'))
        ->pluck('total', 'month')->toArray();

        $attests = AttestDetail::select(DB::raw('MONTH(start_attest) as month'), DB::raw('count(*) as total'))
        ->whereYear('start_attest', '=', now()->year)
        ->groupBy(DB::raw('MONTH(start_attest)'))
        ->pluck('total', 'month')->toArray();

        $monthlyAdmissions = array_fill(1, 12, 0);
        $monthlyOccurrences = array_fill(1, 12, 0);
        $monthlyAttests = array_fill(1, 12, 0);

        foreach ($admissions as $month => $total) {
            $monthlyAdmissions[$month] = $total;
        }

        foreach ($delays as $month => $total) {
            $monthlyOccurrences[$month] = $total;
        }

        foreach ($attests as $month => $total) {
            $monthlyAttests[$month] = $total;
        }
    
        return view('dashboard', compact(
            'countEmployee',
            'countDelay',
            'countAttest',
            'countAdjuntancy',
            'countEpi',
            'countOccurrence',
            'countSalary',
            'topSalaries',
            'adjuntancyLabels',
            'adjuntancyTotals',
            'monthlyAdmissions',
            'monthlyOccurrences',
            'monthlyAttests'
        ));
    }
    /**
     * Show the form for editing the specified resource.
     */
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
