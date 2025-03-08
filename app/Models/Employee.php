<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['user_id', 'job_title_id', 'salary', 'department_id', 'hire_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Job::class, 'job_title_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'employee_id');
    }

    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'employee_formation');
    }

    public function vacationRequests()
    {
        return $this->hasMany(VacationRequest::class);
    }
}
