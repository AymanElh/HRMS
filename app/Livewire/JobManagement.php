<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;
use App\Models\Department;

class JobManagement extends Component
{
    public $jobs;
    public $title = '';
    public $description = '';
    public $jobId;
    public $isOpen = false;
    public $isEdit = false;
    public $departments;
    public $department_id;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'department_id' => 'required'
    ];

    public function mount()
    {
        $this->resetInputFields();
        $this->departments = Department::all();
    }

    public function render()
    {
        $this->jobs = Job::latest()->get();
        return view('livewire.job-management', [
            'jobs' => $this->jobs,
            'departments' => $this->departments
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isEdit = false;
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $this->jobId = $id;
        $this->title = $job->title;
        $this->description = $job->description;
        $this->department_id = $job->department_id;
        $this->isEdit = true;
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();
        // dd($this->department_id);
        Job::updateOrCreate(
            ['id' => $this->jobId ?? null],
            [
                'title' => $this->title,
                'description' => $this->description,
                'department_id' => $this->department_id
            ]
        );

        session()->flash('message', $this->isEdit ? 'Job updated successfully!' : 'Job created successfully!');

        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Job::find($id)->delete();
        session()->flash('message', 'Job deleted successfully!');
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->jobId = null;
        $this->department_id = null;
    }
}
