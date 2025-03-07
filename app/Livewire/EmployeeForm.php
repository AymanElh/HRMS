<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Job;
use Livewire\Component;
use App\Models\Department;
use Spatie\Permission\Models\Role;

class EmployeeForm extends Component
{
    public $employee;
    public $departments = [];
    public $jobs = [];
    public $roles;
    public $selectedDepartment = '';
    public $search = '';

    public function mount($employee = null)
    {
        $this->employee = $employee;
        // dump($this->employee);
        $user = auth()->user();
        if($user->hasRole('Manager')) {
            $this->departments = Department::where('id', $user->employee->department_id)->get();
            // dd($this->departments);
        }
        else {
            // Get all departments
            $this->departments = Department::orderBy('name')->get();
        }

        // Handle the roles assignments base the role
        if($user->hasRole('Admin')) {
            $this->roles = Role::whereNotIn('name', ['admin'])->get();
            // dd($this->roles);
        }
        elseif ($user->hasRole('HR')) {
            $this->roles = Role::whereIn('name', ['HR', 'Manager', 'Employee']);
        }
        elseif ($user->hasRole('Manager')) {
            $this->roles = Role::where('name', 'Employee')->get();
            // dd($this->roles);
        }
    }

    public function jobsByDepartment($department)
    {
        $this->jobs = Job::where('department_id', $department)->get();
    }

    // app/Livewire/EmployeeForm.php

    public $selectedFormation;

    public function assignFormation()
    {
        $this->validate([
            'selectedFormation' => 'required|exists:formations,id',
        ]);

        $employee = Employee::find($this->employee->id);
        $employee->formations()->attach($this->selectedFormation);

        session()->flash('message', 'Formation assigned successfully!');
    }


    public function render()
    {
        return view('livewire.employee-form');
    }
}
