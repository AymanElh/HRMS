<?php

use App\Livewire\DepartmentManagement;
use App\Livewire\FormationManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/departments', DepartmentManagement::class)->name('departments.index');
Route::get('/formations', FormationManagement::class)->name('formations.index');

Route::get('/dashboard/users', [UserController::class, 'index'])->name('users.index');
Route::post('/dashboard/users', [UserController::class, 'store'])->name('users.store');
Route::put('/dashboard/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/dashboard/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
