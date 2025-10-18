<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

// Dashboard Routes
// ---------------------
Route::controller(DashboardController::class)
    ->middleware('auth:web')
    ->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::get('rooms', 'rooms')->name('rooms');
        Route::get('rooms-management', 'roomsManagement')->name('rooms.management');
        Route::get('cafeteria', 'cafeteria')->name('cafeteria');
        Route::get('sessions', 'sessions')->name('sessions');
        Route::get('cafeteria-overview', 'cafeteriaOverview')->name('cafeteria.overview');
        Route::get('session-summary/{session}', 'sessionSummary')->name('session.summary');
        Route::post('session-summary/{session}/cancel-on-close', 'cancelSessionOnClose')->name('session.cancel-on-close');
        Route::get('talabat/{session}', 'talabat')->name('talabat');
        Route::get('reports', 'reports')->name('reports.index');
    });

// Dashboard Routes
// ==============================================================================
Route::name('dashboard.')
    ->middleware('auth:web')
    ->group(function () {});
