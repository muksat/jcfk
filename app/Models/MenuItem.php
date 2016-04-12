<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $dates = ['date'];

    public $timestamps = false;

    public function meal()
    {
        return $this->belongsTo('Jcfk\Models\Meal');
    }
}
