<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalServices = Service::count();

        $activeServices = Service::where('actif', true)->count();

        $inactiveServices = Service::where('actif', false)->count();

        $recentServices = Service::orderBy('id_service', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalServices',
            'activeServices',
            'inactiveServices',
            'recentServices'
        ));
    }
}