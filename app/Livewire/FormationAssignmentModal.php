<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Formation;
use App\Models\Employee;

class FormationAssignmentModal extends Component
{
    public $showModal = false;
    public $employeeId;
    public $selectedFormation;
    public $startDate;
    public $endDate;
    public $status = 'pending';
    public $availableFormations;

    protected $listeners = ['openModal' => 'show'];

    public function mount($employeeId)
    {
        $this->employeeId = $employeeId;
        $this->availableFormations = Formation::orderBy('title')->get();

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
        $this->validate([
            'selectedFormation' => 'required|exists:formations,id',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after:startDate',
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $employee = Employee::find($this->employeeId);
        
        $employee->formations()->attach($this->selectedFormation, [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'status' => $this->status
        ]);

        $this->closeModal();
        $this->emit('formationAssigned');
        session()->flash('message', 'Formation assigned successfully.');
    }

    public function render()
    {
        return view('livewire.formation-assignment-modal', [
            'formations' => Formation::all()
        ]);
    }
}