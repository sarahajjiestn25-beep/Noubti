<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Verifie que l'utilisateur connecte possede l'un des roles autorises.
     *
     * Usage dans les routes :
     * Route::middleware('role:superadmin')->group(...)
     * Route::middleware('role:superadmin,admin')->group(...)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $userRole = $user->role->nom_role ?? null;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Acces non autorise pour votre role.');
        }

        return $next($request);
    }
}