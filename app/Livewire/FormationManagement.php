<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Formation;

class FormationManagement extends Component
{
    public $formations;
    public string $title = '';
    public string $description = '';
    public string $duration = '';
    public $formationId;
    public $isOpen = false;
    public $isEdit = false;
    public $search = '';

    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->resetInputFields();
    }

    public function render()
    {
        $this->formations = Formation::query()->when($this->search, function($query) {
            return $query->where('title', 'like', '%' . $this->search . '%');
        })->get();
        return view('livewire.formation-management');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isEdit = false;
    }

    public function edit($id)
    {
        $formation = Formation::findOrFail($id);
        $this->formationId = $id;
        $this->title = $formation->name;
        $this->description = $formation->description;
        $this->duration = $formation->duration;
        $this->isEdit = true;
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();
        Formation::updateOrCreate(
            ['id' => $this->formationId ?? null],
            [
                'title' => $this->title,
                'description' => $this->description,
                'duration' => $this->duration
            ]
        );

        session()->flash('message', $this->isEdit ? 'Formation updated successfully!' : 'Formation created successfully!');

        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Formation::find($id)->delete();
        session()->flash('message', 'Formation deleted successfully!');
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->duration = '';
        $this->formationId = null;
    }
}
