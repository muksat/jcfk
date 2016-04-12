<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Parents extends Model
{
    protected $table = 'parent';

    public $timestamps = false;

    public $primaryKey = 'user_id';

    protected $fillable = ['name', 'phone', 'address', 'city_id', 'region', 'postalcode'];


    public function user()
    {
        return $this->belongsTo("Jcfk\Models\User");
    }

    public function students()
    {
        return $this->hasMany('Jcfk\Models\Student', 'user_id', 'user_id');
    }

    public function paginateWithUsers($page, $limit)
    {
        $offset = ($page-1) * $limit;

        $parents = $this->select(['parent.user_id', 'user.email', 'user.is_active', 'parent.name', 'parent.phone'])
            ->join('user', 'parent.user_id', '=', 'user.user_id')
            ->where('user.is_active', '=', 1)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return new LengthAwarePaginator($parents, $this->count(), $limit, $page);
    }

    /**
     * @param $schoolName
     * @return Collection
     */
    public function searchByName($parentName)
    {
        return $this->where('name', 'like', "%{$parentName}%")
            ->get();
    }
}
