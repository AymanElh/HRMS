<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Employee;
use App\Models\RecoveryBalance;

class RecoveryRequest extends Component
{
    public $employee;
    public $start_date;
    public $end_date;
    public $days;

    // We'll fetch the employee's previous recovery requests in render()
    public function mount($employee)
    {
        $this->employee = $employee;
    }

    protected $rules = [
        'start_date' => 'required|date|after_or_equal:today',
        'end_date'   => 'required|date|after_or_equal:start_date',
    ];

    public function submitRequest()
    {
        $this->validate();
        $balance = RecoveryBalance::where('employee_id', $this->employee->id)->first()->current_balance;
        // dd($balance);
        $days = Carbon::parse($this->start_date)->diffInDaysFiltered(function (Carbon $date) {
            return !$date->isWeekend();
        }, Carbon::parse($this->end_date));
        // dump($days, $balance);
        if(intval($days) > intval($balance)) {
            session()->flash('error', "You can't get more than your balance");
            return;
        }
        \App\Models\RecoveryRequest::create([
            'employee_id'    => $this->employee->id,
            'start_date'     => $this->start_date,
            'end_date'       => $this->end_date,
            'days' => Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)),
            'status' => 'pending',
        ]);

        session()->flash('message', 'Recovery request submitted successfully!');

        // Reset the form fields.
        $this->reset(['start_date', 'end_date', 'days']);
    }

    public function render()
    {
        // Retrieve existing recovery requests for the employee.
        $requests = \App\Models\RecoveryRequest::where('employee_id', $this->employee->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.recovery-request', [
            'recoveryRequests' => $requests
        ]);
    }
}
