<?php

use App\Livewire\JobManagement;
use App\Livewire\ContractManagement;
use App\Livewire\FormationManagement;
use Illuminate\Support\Facades\Route;
use App\Livewire\DepartmentManagement;
use App\Http\Controllers\EmployeeController;

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
Route::get('/jobs', JobManagement::class)->name('jobs.index');
Route::get('/contracts', ContractManagement::class)->name('contracts.index');

Route::resource('/employees', EmployeeController::class);

//Route::get('/dashboard/users', [UserController::class, 'index'])->name('users.index');
//Route::post('/dashboard/users', [UserController::class, 'store'])->name('users.store');
//Route::put('/dashboard/users/{user}', [UserController::class, 'update'])->name('users.update');
//Route::delete('/dashboard/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
