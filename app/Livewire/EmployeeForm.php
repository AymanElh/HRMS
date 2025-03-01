<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;
use App\Models\Department;

class EmployeeForm extends Component
{
    public $departments = [];
    public $jobs = [];

    public $selectedDepartment = '';

    public function mount() 
    {
        $this->departments = Department::orderBy('name')->get();
        // dd($this->departments);
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
