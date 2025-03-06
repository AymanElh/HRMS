<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacationBalance extends Model
{
    protected $fillable = [
        'employee_id', 
        'current_balance', 
        'acuired_days', 
        'last_update'
    ];
}
