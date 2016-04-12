<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /**
     * @var string
     */
    protected $table = 'meal';

    /**
     * @var string
     */
    public $primaryKey = 'meal_id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['meal_name', 'description'];

    /**
     * @param $schoolName
     * @return Collection
     */
    public function searchByName($mealName)
    {
        return $this->where('meal_name', 'like', "%{$mealName}%")
            ->get();
    }
}
