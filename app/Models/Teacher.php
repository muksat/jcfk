<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $appends = ['school_name'];

    protected $table = 'teacher';

    public $primaryKey = 'teacher_id';

    public $timestamps = false;

    protected $fillable = ['name', 'school_id','room'];

    public function getSchoolNameAttribute()
    {
        return $this->school->name;
    }

    public function school()
    {
        return $this->belongsTo('Jcfk\Models\School');
    }

    public function search($teacherName)
    {
        return $this->where('name', 'like', '%' . $teacherName . '%')
            ->get();
    }
}
