<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'department_id'];
    protected $table = 'jobs_titles';

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

}
