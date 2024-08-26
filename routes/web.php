<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViaggioController;
use App\Http\Controllers\GiornataController;
use App\Http\Controllers\TappaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ViaggioController::class, 'index'])->name('home');

// Proteggi le rotte con middleware 'auth'
Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('viaggi', ViaggioController::class);
        Route::resource('giornate', GiornataController::class);
        Route::resource('tappe', TappaController::class);
    });

require __DIR__ . '/auth.php';