<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;
use App\Models\Department;

class EmployeeForm extends Component
{
    public $employee;
    public $departments = [];
    public $jobs = [];

    public $selectedDepartment = '';

    public function mount($employee = null) 
    {
        $this->employee = $employee;
        $this->departments = Department::orderBy('name')->get();
        if ($employee) {
            $this->selectedDepartment = $employee->department_id;
            $this->jobsByDepartment($employee->department_id);
        }
        // dd($this->employee);
    }

    public function jobsByDepartment($department) 
    {
        $this->jobs = Job::where('department_id', $department)->get();
    }

    public function render()
    {
        return view('livewire.employee-form');
    }
}
