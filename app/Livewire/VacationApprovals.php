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
        $this->userRole = $user->hasRole('HR') ? 'hr' : 'manager';
    }

    public function approve($requestId)
    {
        // dd($requestId);
        $request = VacationRequest::findOrFail($requestId);
        // dd(auth()->user()->employee->id);
        if ($this->userRole === 'manager') {
            $request->update([
                'manager_id' => auth()->user()->employee->id,
                'manager_validated_at' => now(),
                'status' => 'manager_approved'
            ]);
            session()->flash('message', 'Request approved by manager, waiting for HR approval.');
        } else {
            // Only HR can approve if manager has already approved
            // dd($request);
            if ($request->manager_validated_at) {
                // dd("manager approved");
                $request->update([
                    'hr_id' => auth()->user()->employee->id,
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
                'manager_id' => auth()->user()->employee->id,
                'manager_validated_at' => now(),
                'manager_comments' => $this->rejectReason,
                'status' => 'manager_rejected'
            ]);
        } else {
            $request->update([
                'hr_id' => auth()->user()->employee->id,
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
        if($this->userRole === 'manager') {
            // dump('manager');
            $pendingRequests = VacationRequest::where('status', 'pending')->latest()->get();
            $historyRequests = VacationRequest::whereIn('status', ['approved', 'manager_rejected', 'hr_rejected'])
            ->whereHas('employee', function($query) {
                $query->where('manager_id', auth()->user()->employee->id);
            })
            ->latest()
            ->get();
        }
        else {
            // dump('hr');
            $pendingRequests = VacationRequest::whereIn('status', ['pending', 'manager_approved'])->latest()->get();
            $historyRequests = VacationRequest::whereIn('status', ['approved', 'manager_rejected', 'hr_rejected'])
            ->latest()
            ->get();
        }

        // dd($pendingRequests);
        return view('livewire.vacation-approvals', [
            'pendingRequests' => $pendingRequests,
            'userRole' => $this->userRole,
            'historyRequests' => $historyRequests
        ]);
    }
}