<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;

class JobManagement extends Component
{
    public $jobs;
    public $title = '';
    public $description = '';
    public $jobId;
    public $isOpen = false;
    public $isEdit = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string'
    ];

    public function mount()
    {
        $this->resetInputFields();
    }

    public function render()
    {
        $this->jobs = Job::latest()->get();
        return view('livewire.job-management', ['jobs' => $this->jobs]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isEdit = false;
    }

    public function edit($id)
    {
        $job = Jobs::findOrFail($id);
        $this->jobId = $id;
        $this->title = $job->title;
        $this->description = $job->description;
        $this->isEdit = true;
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();
        Job::updateOrCreate(
            ['id' => $this->jobId ?? null],
            [
                'title' => $this->title,
                'description' => $this->description
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
    }
}
