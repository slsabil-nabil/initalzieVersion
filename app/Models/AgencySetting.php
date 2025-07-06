<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'logo',
        'agency_name',
        'main_branch_name',
        'currency',
        'phone',
        'landline',
        'email',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}

