<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicListItem extends Model
{
    protected $fillable = ['dynamic_list_id', 'label', 'order'];

    public function list()
    {
        return $this->belongsTo(DynamicList::class, 'dynamic_list_id');
    }
}

