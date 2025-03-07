<?php

use App\Livewire\JobManagement;
use App\Livewire\ContractManagement;
use Illuminate\Support\Facades\Auth;
use App\Livewire\FormationManagement;
use Illuminate\Support\Facades\Route;
use App\Livewire\DepartmentManagement;
use App\Http\Controllers\EmployeeController;
use App\Models\Employee;

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

    Route::get('/departments', DepartmentManagement::class)->name('departments.index');
    Route::get('/formations', FormationManagement::class)->name('formations.index');
    Route::get('/jobs', JobManagement::class)->name('jobs.index');
    Route::get('/contracts', ContractManagement::class)->name('contracts.index');
    Route::resource('/employees', EmployeeController::class);
});

Route::middleware('role:Admin|Manager')->group(function() {
    Route::resource('/employees', EmployeeController::class);
});

Route::middleware('role:Admin')->group(function() {
    Route::get('/departments', DepartmentManagement::class)->name('departments.index');
    Route::get('/formations', FormationManagement::class)->name('formations.index');
    Route::get('/jobs', JobManagement::class)->name('jobs.index');
    Route::get('/contracts', ContractManagement::class)->name('contracts.index');
});



Route::get('/employees/profile/{employee}', [EmployeeController::class, 'profile'])->name('employees.profile');


Route::get('/vacations', function() {
    return view('vacations.index');
})->name('vacations.index');


Route::get('/vacation-approvals', function () {
    return view('vacations.approvals');
})->name('vacation.approvals');