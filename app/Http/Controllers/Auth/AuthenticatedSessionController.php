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
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // vérifier login
        $request->authenticate();

        // regenerate session
        $request->session()->regenerate();

        // user connecté
        $user = Auth::user();

        // récupérer role
        $roleName = $user->role->nom_role ?? null;

        // redirect حسب role
        return match ($roleName) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            'responsable' => redirect()->route('responsable.dashboard'),
            'client' => redirect()->route('home'),
            default => redirect()->route('home'),
        };
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}