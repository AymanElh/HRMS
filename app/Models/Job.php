<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'department_id'];
    protected $table = 'jobs_titles';
    
    public function department()
    {
        return $this->belongsTo(department::class, 'department_id');
    }

}
