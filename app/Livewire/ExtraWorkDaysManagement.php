<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\RecoveryBalance;

class ExtraWorkDaysManagement extends Component
{
    public $employee;
    public $extraDaysToAdd = 0;
    public $showModal = false;

    protected $rules = [
        'extraDaysToAdd' => 'required|numeric|min:0.1',
    ];

    public function mount($employee)
    {
        // $employee is passed from the parent view
        $this->employee = $employee;
    }

    public function addExtraDays()
    {
        $this->validate();

        // Retrieve or create the recovery balance for the employee
        $balanceRecord = RecoveryBalance::firstOrCreate(
            ['employee_id' => $this->employee->id],
            ['current_balance' => 0]
        );

        // Add the new extra days to the current balance
        $balanceRecord->current_balance += $this->extraDaysToAdd;
        $balanceRecord->save();

        session()->flash('message', 'Extra work days added successfully!');

        // Reset the input and close the modal
        $this->reset('extraDaysToAdd');
        $this->showModal = false;
    }

    public function render()
    {
        $balance = RecoveryBalance::where('employee_id', $this->employee->id)->first();
        // dd($balance);
        return view('livewire.extra-work-days-management', [
            'balance' => $balance
        ]);
    }
}
