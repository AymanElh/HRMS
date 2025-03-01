<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{

    protected $fillable = [
        'type',
        'description'
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
