<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\RecoveryRequest;
use App\Models\VacationRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalEmployees' => Employee::count(),
            'totalDepartments' => Department::count(),
            'pendingVacations' => VacationRequest::where('status', 'pending')->count(),
            'pendingRecoveryDays' => RecoveryRequest::where('status', 'pending')->count(),
            'recentVacationRequests' => VacationRequest::with('employee.user')
                ->latest()
                ->take(5)
                ->get(),

            // New: Monthly vacation request statistics
            'monthlyStats' => $this->getMonthlyStats(),
            
            // New: Department statistics
            'departmentStats' => $this->getDepartmentStats(),
        ];

        return view('dashboard', compact('stats'));
    }

    private function getMonthlyStats()
    {
        $year = Carbon::now()->year;
        return collect(range(1, 12))->map(function($month) use ($year) {
            return VacationRequest::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
        })->toArray();
    }

    private function getDepartmentStats()
    {
        return Department::withCount('employees')
            ->with(['employees.vacationRequests' => function($query) {
                $query->where('status', 'pending');
            }])
            ->get()
            ->map(function($department) {
                return [
                    'name' => $department->name,
                    'employeeCount' => $department->employees_count,
                    'pendingRequests' => $department->employees->sum(function($employee) {
                        return $employee->vacationRequests->count();
                    })
                ];
            });
    }
}
