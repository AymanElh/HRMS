<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\ContractType;

class ContractManagement extends Component
{
    public $contracts;
    public $contract_id;
    public $employee_id;
    public $startDate = '';
    public $endDate = '';
    public $contractType;
    public $salary;
    public $status;
    public bool $isOpen = false;
    public $search;
    public $searchBy = 'salary';

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'contractType' => 'required|exists:contract_types,id',
        'startDate' => 'required|date|after:now',
        'endDate' => 'required|date|after_or_equal:startDate',
        'salary' => 'required|numeric|min:0',
        'status' => 'required|in:active,finished',
    ];

    public function mount() 
    {
        $this->contracts = Contract::all();
    }

    public function create()
    {
        $this->resetInputsFields();
        $this->openModal();
    }

    public function store()
    {
        $this->validate();
        if($this->contract_id) {
            $contract = Contract::find($this->contract_id);
            $contract->update([
                'employee_id' => $this->employee_id,
                'contractType' => $this->contractType,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'salary' => $this->salary,
                'status' => $this->status,
            ]);
            session()->flash('message', "Contract Updated Successfully");
        } else {
            Contract::create([
                'employee_id' => $this->employee_id,
                'contractType' => $this->contractType,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'salary' => $this->salary,
                'status' => $this->status,
            ]);
            session()->flash('message', "Contract Added Successfully");
        }

        $this->resetInputsFields();
        $this->closeModal();
        $this->contracts = Contract::all();
    }

    public function edit($id)
    {
        $contract = Contract::find($id);
        $this->contract_id = $contract->id;
        $this->employee_id = $contract->employee_id;
        $this->contractType = $contract->contractType;
        $this->startDate = $contract->startDate;
        $this->endDate = $contract->endDate;
        $this->salary = $contract->salary;
        $this->status = $contract->status;

        $this->openModal();
    }

    public function delete($id)
    {
        Contract::find($id)->delete();
        $this->contracts = Contract::all(); 
        session()->flash('message', "Conract Delete Successfully");
    }

    private function resetInputsFields()
    {
        $this->employee_id = '';
        $this->contractType = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->salary = '';
        $this->status = '';
        $this->contract_id = null;
    }

    private function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function updatedSearch()
    {
        $this->contracts = Contract::where('status', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('employee.user', function ($query) {
                // dump($query);
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('type', function($query) {
                // dump($query);
                $query->where('type', 'LIKE', '%' . $this->search . '%');
            })
            ->get();
    }

    public function render()
    {
        // dd(Employee::all());
        return view('livewire.contract-management', [
            'employees' => Employee::all(),
            'contractTypes' => ContractType::all()
        ]);
    }
}
