<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        // Cek role dengan Spatie
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return redirect()->intended(route('dashboard')); // dashboard untuk admin
        } elseif ($user->hasRole('user')) {
            return redirect()->intended(route('petugas.home')); // halaman khusus user/petugas
        }

        // Default fallback (jika role tidak dikenali)
        Auth::logout();
        return redirect('/login')->withErrors(['role' => 'Role tidak valid.']);
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
