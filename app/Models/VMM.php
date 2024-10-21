<?php

namespace App\Models;

use App\Enums\VMMStatus;
use Illuminate\Database\Eloquent\Model;

class VMM extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => VMMStatus::class,
        ];
    }

    public function investments()
    {
        return $this->hasMany(Investment::class, 'vmm_id');
    }
}
