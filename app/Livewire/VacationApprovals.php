<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VacationRequest;
use Illuminate\Support\Facades\Auth;

class VacationApprovals extends Component
{
    public $showRejectModal = false;
    public $selectedRequestId;
    public $rejectReason;
    public $userRole;

    public function mount()
    {
        $user = auth()->user();
        if(!$user) {
            dd("user is not authenticated");
        }
        $this->userRole = $user->hasRole('hr') ? 'hr' : 'manager';
    }

    public function approve($requestId)
    {
        $request = VacationRequest::findOrFail($requestId);
        
        if ($this->userRole === 'manager') {
            $request->update([
                'manager_id' => auth()->id(),
                'manager_validated_at' => now(),
                'status' => 'manager_approved'
            ]);
            session()->flash('message', 'Request approved by manager, waiting for HR approval.');
        } else {
            // Only HR can approve if manager has already approved
            if ($request->manager_validated_at) {
                $request->update([
                    'hr_id' => auth()->id(),
                    'hr_validated_at' => now(),
                    'status' => 'approved'
                ]);
                session()->flash('message', 'Request fully approved.');
            } else {
                session()->flash('error', 'Manager approval required first.');
            }
        }
    }

    public function openRejectModal($requestId)
    {
        $this->selectedRequestId = $requestId;
        $this->showRejectModal = true;
    }

    public function reject()
    {
        $request = VacationRequest::findOrFail($this->selectedRequestId);
        
        if ($this->userRole === 'manager') {
            $request->update([
                'manager_id' => auth()->id(),
                'manager_validated_at' => now(),
                'manager_comments' => $this->rejectReason,
                'status' => 'manager_rejected'
            ]);
        } else {
            $request->update([
                'hr_id' => auth()->id(),
                'hr_validated_at' => now(),
                'hr_comments' => $this->rejectReason,
                'status' => 'hr_rejected'
            ]);
        }

        $this->showRejectModal = false;
        $this->reset(['selectedRequestId', 'rejectReason']);
        session()->flash('message', 'Vacation request rejected.');
    }

    public function render()
    {
        // $query = VacationRequest::with(['employee', 'manager', 'hr'])
        //     ->when($this->userRole === 'manager', function($query) {
        //         return $query->whereHas('employee', function($q) {
        //             $q->where('manager_id', auth()->id());
        //         })->whereIn('status', ['pending', 'manager_approved']);
        //     })
        //     ->when($this->userRole === 'hr', function($query) {
        //         return $query->whereIn('status', ['pending', 'manager_approved']);
        //     })
        //     ->latest();

        $query = VacationRequest::where('status', 'pending');

        return view('livewire.vacation-approvals', [
            'pendingRequests' => $query->get(),
            'userRole' => $this->userRole
        ]);
    }
}