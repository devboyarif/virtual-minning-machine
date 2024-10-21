<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VMM extends Model
{
    protected $guarded = [];

    public function investment()
    {
        return $this->hasOne(Investment::class, 'vmm_id');
    }
}
