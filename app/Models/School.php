<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * @var string
     */
    protected $appends = ['city_name'];
    protected $table = 'school';

    /**
     * @var string
     */
    public $primaryKey = 'school_id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'phone', 'address', 'city_id', 'region', 'postalcode', 'is_active', 'meal_price', 'website'];

    public function getCityNameAttribute()
    {
        return $this->city->name;
    }

    public function city()
    {
        return $this->belongsTo('Jcfk\Models\City');
    }

    /**
     * @param $schoolName
     * @return Collection
     */
    public function searchByName($schoolName)
    {
        return $this->where('name', 'like', "%{$schoolName}%")
            ->get();
    }
}
