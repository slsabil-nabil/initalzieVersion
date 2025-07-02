<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = ['name'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}