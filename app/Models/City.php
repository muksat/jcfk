<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    public $primaryKey = 'city_id';

    public function getByRegion($regionCode)
    {
        return $this->where('region', $regionCode)
            ->get();
    }
}
