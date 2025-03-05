<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Formation;
use App\Models\Employee;

class EmployeeFormations extends Component
{
    public $employee;
    public $showModal = false;
    public $selectedFormation;
    public $startDate;
    public $endDate;
    public $status = 'Pending';

    protected $rules = [
        'selectedFormation' => 'required|exists:formations,id',
        'startDate' => 'required|date',
        'endDate' => 'nullable|date|after:startDate'
    ];

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['selectedFormation', 'startDate', 'endDate', 'status']);
    }

    public function assignFormation()
    {
        $this->validate();

        $this->employee->formations()->attach($this->selectedFormation, [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate
        ]);

        $this->closeModal();
        session()->flash('message', 'Formation assigned successfully.');
    }

    public function render()
    {
        return view('livewire.employee-formations', [
            'formations' => Formation::all(),
            'employeeFormations' => $this->employee->formations
        ]);
    }
}