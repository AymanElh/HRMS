<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class RecoveryRequest extends Model
{
    protected $fillable = ['employee_id', 'start_date', 'end_date', 'days', 'status'];

    public function employee() 
    {
        return $this->belongsTo(Employee::class);
    }
}
