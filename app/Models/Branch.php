<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['agency_id', 'name', 'phone', 'email', 'address'];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}

