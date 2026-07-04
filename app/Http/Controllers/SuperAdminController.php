<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    /**
     * Affiche le dashboard du SuperAdmin.
     */
    public function dashboard(Request $request): View
    {
        return view('superadmin.dashboard');
    }
}
