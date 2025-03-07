<?php

namespace App\Models;

use App\Models\Employee;
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
        'manager_validated_at',
        'hr_id',
        'hr_validated_at',
        'hr_comments',
        'manager_comments'
    ];

    
    /**
     * Get the employee that owns the vacation request.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
