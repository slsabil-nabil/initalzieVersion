<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicList extends Model
{
    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(DynamicListItem::class)->orderBy('order');
    }
}

