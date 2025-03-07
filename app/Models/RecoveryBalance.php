<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecoveryBalance extends Model
{
    protected $fillable = ['employee_id', 'current_balance'];
}
