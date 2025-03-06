<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacationRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'manager_id',
        'manager_approval_at',
        'hr_id',
        'hr_approval_at',
        'hr_comments',
        'manager_comments'
    ];
}
