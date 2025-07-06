<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'license_number',
        'commercial_record',
        'tax_number',
        'logo',
        'description',
        'status',
        'license_expiry_date',
        'max_users',
    ];

    protected $casts = [
        'license_expiry_date' => 'date',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function admin()
    {
        return $this->hasOne(User::class)->where('user_type', 'agency_admin');
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isLicenseExpired()
    {
        return $this->license_expiry_date->isPast();
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function setting()
    {
        return $this->hasOne(AgencySetting::class);
    }

    public function branches()
    {
        return $this->hasMany(\App\Models\Branch::class);
    }
}
