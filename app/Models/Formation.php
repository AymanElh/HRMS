<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    /** @use HasFactory<\Database\Factories\FormationFactory> */
    use HasFactory;
    protected $fillable = ['title', 'description', 'duration'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_formation');
    }
}
