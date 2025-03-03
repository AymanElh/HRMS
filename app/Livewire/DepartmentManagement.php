<?php

namespace App\Livewire;

use App\Models\Department;
use Livewire\Component;

class DepartmentManagement extends Component
{
    public $departments;
    public $name = '';
    public $description = '';
    public $departmentId;
    public $isOpen = false;
    public $isEdit = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string'
    ];

    public function mount()
    {
        $this->resetInputFields();
    }

    public function render()
    {
        $this->departments = Department::query()->when($this->search, function($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->get();
        return view('livewire.department-management');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isEdit = false;
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $this->departmentId = $id;
        $this->name = $department->name;
        $this->description = $department->description;
        $this->isEdit = true;
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        Department::updateOrCreate(
            ['id' => $this->departmentId ?? null],
            [
                'name' => $this->name,
                'description' => $this->description
            ]
        );

        session()->flash('message', $this->isEdit ? 'Department updated successfully!' : 'Department created successfully!');

        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Department::find($id)->delete();
        session()->flash('message', 'Department deleted successfully!');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->departmentId = null;
    }
}
