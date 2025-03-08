<?php

use App\Models\Employee;
use App\Livewire\JobManagement;
use App\Livewire\ContractManagement;
use Illuminate\Support\Facades\Auth;
use App\Livewire\FormationManagement;
use Illuminate\Support\Facades\Route;
use App\Livewire\DepartmentManagement;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/departments', DepartmentManagement::class)->name('departments.index');
    Route::get('/formations', FormationManagement::class)->name('formations.index');
    Route::get('/jobs', JobManagement::class)->name('jobs.index');
    Route::get('/contracts', ContractManagement::class)->name('contracts.index');
    Route::resource('/employees', EmployeeController::class);
});

Route::middleware('role:Admin|Manager|HR')->group(function() {
    Route::resource('/employees', EmployeeController::class);
});

Route::middleware('role:Admin')->group(function() {
    Route::get('/departments', DepartmentManagement::class)->name('departments.index');
    Route::get('/jobs', JobManagement::class)->name('jobs.index');
});

Route::middleware('role:Admin|HR')->group(function() {
    Route::get('/contracts', ContractManagement::class)->name('contracts.index');
    Route::get('/formations', FormationManagement::class)->name('formations.index');
});

Route::middleware('role:Manager|HR|Employee')->group(function(){

    Route::get('/employees/profile/{employee}', [EmployeeController::class, 'profile'])->name('employees.profile');
});


Route::middleware('role:Employee|Manager')->group(function() {
    Route::get('/vacations', function() {
        return view('vacations.index');
    })->name('vacations.index');
    
    Route::get('/recovery-days', function() {
        return view('recovery-days.index');
    })->name('recovery-days.index');
});


Route::middleware('role:HR|Manager')->group(function() {
    Route::get('/vacation-approvals', function () {
        return view('vacations.approvals');
    })->name('vacation.approvals');
});

Route::middleware('role:HR')->group(function() {
    Route::get('/recovery-days-approvals', function() {
        return view('recovery-days.approvals');
    })->name('recovery-days.approvals');
});

Route::get('/hearchy', function() {
    return view('organigram.hearchy');
})->name('hearchy');
