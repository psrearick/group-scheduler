<?php

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
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::get('/', [
    \App\Http\Controllers\DashboardController::class, 'show',
])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [
    \App\Http\Controllers\DashboardController::class, 'show',
])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->post('/users', [
    \App\Http\Controllers\UserMemberController::class, 'store',
]);

Route::middleware(['auth:sanctum', 'verified', 'requestsValidGroup'])
    ->resource('groups.schedules', \App\Http\Controllers\ScheduleController::class)
    ->except(['create']);

Route::middleware(['auth:sanctum', 'verified'])->prefix('groups')->group(function () {
    Route::post('/', [\App\Http\Controllers\GroupController::class, 'store']);
    Route::delete('/', [\App\Http\Controllers\UserGroupAccessController::class, 'destroy'])->name('groups.exit');
    Route::get('/{group}/edit', [\App\Http\Controllers\GroupController::class, 'edit'])->name('groups.edit');
    Route::post('/{group}/events', [\App\Http\Controllers\EventController::class, 'store']);
    Route::get('/create', [\App\Http\Controllers\GroupController::class, 'create'])->name('groups.create');
    Route::get('/join', [\App\Http\Controllers\UserGroupController::class, 'create']);
    Route::get('/members', [\App\Http\Controllers\MemberController::class, 'index'])
        ->middleware('inGroup')
        ->name('groups.members');
    Route::post('/members', [\App\Http\Controllers\MemberController::class, 'store']);
    Route::get('/{group}', [\App\Http\Controllers\UserGroupAccessController::class, 'show']);
});
