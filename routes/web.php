<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ResponsableDashboardController;
use App\Http\Controllers\Public\PublicReservationController;
use App\Http\Controllers\Public\PublicServiceController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicReservationController::class, 'index'])
    ->name('home');

Route::get('/reserver', [PublicReservationController::class, 'index'])
    ->name('public.reservation');

Route::post('/reserver', [PublicReservationController::class, 'store'])
    ->name('public.reservation.store');

Route::get('/ticket/{reservation}', [PublicReservationController::class, 'ticket'])
    ->name('public.ticket');

Route::get('/ticket/{reservation}/status', [PublicReservationController::class, 'status'])
    ->name('public.ticket.status');


/*
|--------------------------------------------------------------------------
| Anciennes routes QR
|--------------------------------------------------------------------------
*/

Route::prefix('reservation')
    ->name('public.')
    ->group(function () {

        Route::get('/service/{service}', [PublicServiceController::class, 'show'])
            ->name('service.show');

        Route::post('/service/{service}', [PublicServiceController::class, 'store'])
            ->name('service.store');

        Route::get('/ticket/{reservation}', [PublicServiceController::class, 'ticket'])
            ->name('ticket.show');

        Route::get('/ticket/{reservation}/status', [PublicServiceController::class, 'checkStatus'])
            ->name('ticket.status');

    });


/*
|--------------------------------------------------------------------------
| Protected
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {

        $user = auth()->user();

        return match ($user->role->nom_role) {

            'superadmin' => redirect()->route('superadmin.dashboard'),

            'admin' => redirect()->route('admin.dashboard'),

            'responsable' => redirect()->route('responsable.dashboard'),

            default => redirect('/'),

        };

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | SuperAdmin
    |--------------------------------------------------------------------------
    */

    Route::prefix('superadmin')
        ->middleware('role:superadmin')
        ->name('superadmin.')
        ->group(function () {

            Route::get('/dashboard', fn() => view('superadmin.dashboard'))
                ->name('dashboard');

        });


    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->middleware('role:admin,superadmin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', fn() => view('admin.dashboard'))
                ->name('dashboard');

            Route::resource('services', ServiceController::class);

        });


    /*
    |--------------------------------------------------------------------------
    | Responsable
    |--------------------------------------------------------------------------
    */

    Route::prefix('responsable')
        ->middleware('role:responsable')
        ->name('responsable.')
        ->group(function () {

            Route::get('/dashboard', [ResponsableDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/realtime', [ResponsableDashboardController::class, 'realtime'])
                ->name('realtime');
                
            Route::get('/display', [ResponsableDashboardController::class, 'display'])
                ->name('display');   

            Route::post('/ticket/suivant', [ResponsableDashboardController::class, 'nextTicket'])
                ->name('ticket.suivant');

            Route::post('/ticket/terminer', [ResponsableDashboardController::class, 'finishTicket'])
                ->name('ticket.terminer');

            Route::post('/ticket/annuler', [ResponsableDashboardController::class, 'cancelTicket'])
                ->name('ticket.annuler');

        });

});

require __DIR__.'/auth.php';