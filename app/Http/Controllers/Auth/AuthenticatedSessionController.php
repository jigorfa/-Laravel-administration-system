<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validação dos dados
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'O campo de email é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'password.required' => 'O campo de senha é obrigatório.',
        ]);

        try {
            // Tentar autenticar o usuário
            $request->authenticate();

            // Regenerar a sessão
            $request->session()->regenerate();

            // Redirecionar para a página correta
            if ($request->user()->email === 'adm@gmail.com') {
                return redirect('dashboard');
            }

            return redirect()->intended(route('login'));
        } catch (ValidationException $e) {
            // Em caso de falha na autenticação, redirecionar de volta com os erros
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ])->redirectTo(route('login'));
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
