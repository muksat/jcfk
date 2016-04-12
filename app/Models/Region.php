<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';

    public function getByCountry($countryCode)
    {
        return $this->where('country', $countryCode)
            ->get();
    }
}
