<?php

use App\Http\Controllers\Admin\FinancialController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth:sanctum', 'verified', 'admin.access'], 'prefix' => 'admin'], function () {
    Route::resource('/users', UserController::class);
    Route::resource('/financials', FinancialController::class);
    Route::resource('/request', RequestController::class);
    Route::get('/request/evaluate/{id}', [RequestController::class, 'evaluate'])->name('request.evaluate');
    Route::post('/request/assign', [RequestController::class, 'assign'])->name('request.assign');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
