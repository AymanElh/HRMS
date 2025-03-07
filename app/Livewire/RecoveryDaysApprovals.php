<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RecoveryRequest;
use Illuminate\Support\Facades\Auth;

class RecoveryDaysApprovals extends Component
{
    public $showRejectModal = false;
    public $selectedRequestId;
    public $rejectReason;

    protected $rules = [];

    public function approve($requestId)
    {
        $request = RecoveryRequest::findOrFail($requestId);

        try {
            $request->update([
                'status' => 'approved',
                'hr_id' => auth()->user()->employee->id,
                'hr_validated_at' => now()
            ]);

            // Update employee's recovery balance
            $request->employee->recoveryBalance()->increment('current_balance', $request->days);

            session()->flash('message', 'Recovery request approved successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error approving request.');
            \Log::error('Recovery Request Approval Error:', ['error' => $e->getMessage()]);
        }
    }

    public function openRejectModal($requestId)
    {
        $this->selectedRequestId = $requestId;
        $this->showRejectModal = true;
    }

    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->reset(['selectedRequestId', 'rejectReason']);
        $this->resetValidation();
    }

    public function reject()
    {
        $this->validate();

        $request = RecoveryRequest::findOrFail($this->selectedRequestId);

        try {
            $request->update([
                'status' => 'rejected',
                'hr_id' => auth()->user()->employee->id,
                'hr_validated_at' => now(),
            ]);

            $this->closeRejectModal();
            session()->flash('message', 'Recovery request rejected successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error rejecting request.');
            \Log::error('Recovery Request Rejection Error:', ['error' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.recovery-days-approvals', [
            'pendingRequests' => RecoveryRequest::where('status', 'pending')
                ->with(['employee.user'])
                ->latest()
                ->get(),
            'processedRequests' =>  RecoveryRequest::whereIn('status', ['approved', 'rejected'])
                ->with(['employee.user'])
                ->latest()
                ->take(50)
                ->get()
        ]);
    }
}