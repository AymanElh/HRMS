<?php

namespace App\Livewire;

use Livewire\Component;

class VacationRequestForm extends Component
{
    public $startDate, $endDate, $reason, $currentBalance, $totalDays;

    public function mount()
    {
        $this->loadCurrentBalance();
    }

    public function loadCurrentBalance()
    {
        $balance = VacationBalance::where('employee_id', auth()->id())->first();
        $this->currentBalance = $balance ? $balance->current_balance : 0;
    }

    public function calculateTotalDays()
    {
        if($this->startDate && $this->endDate)
        {
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);
            $this->totalDays = $start->diffInDaysFiltered(function (Carbon $date) {
                return !$date->isWeekend();
            }, $end) + 1;

            dd($this->totalDays);
        }
    }

    public function submit()
    {
        $this->validate();
        
        
        $startDate = Carbon::parse($this->start_date);
        if ($startDate->diffInDays(Carbon::now()) < 7) {
            $this->addError('start_date', 'Vacation requests must be submitted at least 7 days in advance.');
            return;
        }

        
        if ($this->totalDays > $this->currentBalance) {
            $this->addError('end_date', 'Insufficient vacation balance.');
            return;
        }

        VacationRequest::create([
            'employee_id' => auth()->id(),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_days' => $this->totalDays,
            'reason' => $this->reason,
            'status' => 'pending'
        ]);

        session()->flash('message', 'Vacation request submitted successfully.');
        $this->reset(['start_date', 'end_date', 'reason']);
    }

    public function render()
    {
        return view('livewire.vacation-request-form');
    }
}
