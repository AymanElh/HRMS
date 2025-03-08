<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Department;
use Livewire\Component;

class OrganizationChart extends Component
{
    public function getHierarchyData()
    {
        return Department::with(['employees.user', 'employees.position'])
            ->get()
            ->map(function ($department) {
                return [
                    'name' => $department->name,
                    'employees' => $department->employees->map(function ($employee) {
                        return [
                            'name' => $employee->user->name,
                            'position' => $employee->position->title ?? 'No Position',
                            'image' => $employee->user->profile_photo_url,
                        ];
                    })
                ];
            });
    }

    public function render()
    {
        return view('livewire.organization-chart', [
            'hierarchy' => $this->getHierarchyData()
        ]);
    }
}