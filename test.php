

public function mount()
    {
        $this->employee = Employee::where('user_id', auth()->id())->first();
        $this->loadVacationBalance();
    }

    private function loadVacationBalance()
    {
        $this->vacationBalance = VacationBalance::firstOrCreate(
            ['employee_id' => $this->employee->id],
            $this->calculateInitialBalance()
        );
    }

    private function calculateInitialBalance()
    {
        // Calculate years of service
        $employmentStartDate = $this->employee->created_at;
        $yearsOfService = Carbon::now()->diffInYears($employmentStartDate);
        
        if ($yearsOfService < 1) {
            $monthsWorked = Carbon::now()->diffInMonths($employmentStartDate);
            $balance = $monthsWorked * 1.5;
        } else {
            $balance = 18 + (($yearsOfService - 1) * 0.5);
        }

        return [
            'current_balance' => $balance,
            'acquired_days' => $balance,
            'last_balance_update' => now(),
            'years_of_service' => $yearsOfService,
            'employment_start_date' => $employmentStartDate
        ];
    }

    public function calculateTotalDays()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            
            $this->totalDays = $start->diffInDaysFiltered(function (Carbon $date) {
                return !$date->isWeekend();
            }, $end) + 1;
        }
    }

    public function updatedStartDate()
    {
        $this->calculateTotalDays();
    }

    public function updatedEndDate()
    {
        $this->calculateTotalDays();
    }

    public function submitRequest()
    {
        $this->validate();

        if (Carbon::parse($this->start_date)->diffInDays(Carbon::now()) < 7) {
            $this->addError('start_date', 'Vacation requests must be submitted at least 7 days in advance.');
            return;
        }

        if ($this->totalDays > $this->vacationBalance->current_balance) {
            $this->addError('end_date', 'Insufficient vacation balance. You only have ' . 
                number_format($this->vacationBalance->current_balance, 1) . ' days available.');
            return;
        }

        // Create vacation request
        $request = VacationRequest::create([
            'employee_id' => $this->employee->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_days' => $this->totalDays,
            'reason' => $this->reason,
            'status' => 'pending',
            // Get the employee's manager ID from department
            'manager_id' => $this->employee->department->manager_id ?? null
        ]);

        // Reset form
        $this->reset(['start_date', 'end_date', 'reason']);
        session()->flash('message', 'Vacation request submitted successfully!');
    }

    public function render()
    {
        $pendingRequests = VacationRequest::where('employee_id', $this->employee->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.vacation-management', [
            'pendingRequests' => $pendingRequests
        ]);
    }