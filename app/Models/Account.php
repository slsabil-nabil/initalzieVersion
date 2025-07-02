<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['agency_id', 'name', 'type', 'is_active'];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}