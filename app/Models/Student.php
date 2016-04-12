<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $appends = ['teacher_name', 'school_name', 'parent_name'];

    protected $table = 'student';

    public $primaryKey = 'student_id';

    public $timestamps = false;

    protected $fillable = ['name', 'teacher_id', 'user_id'];

    public function teacher()
    {
        return $this->belongsTo('Jcfk\Models\Teacher');
    }

    public function parent()
    {
        return $this->belongsTo('Jcfk\Models\Parents', 'user_id', 'user_id');
    }

    public function getTeacherNameAttribute()
    {
        if (!$this->teacher) {
            return '';
        }

        return $this->teacher->name;
    }

    public function getSchoolNameAttribute()
    {
        if (!$this->teacher) {
            return '';
        }

        return $this->teacher->school->name;
    }

    public function getParentNameAttribute()
    {
        if (!$this->parent) {
            return '';
        }

        return $this->parent->name;
    }

    public function getStudentsWithShcool(User $user)
    {
        return $this->select([
            'student_id',
            'student.name',
            'teacher.school_id',
        ])
            ->join('teacher', 'student.teacher_id', '=', 'teacher.teacher_id')
            ->where('student.user_id', '=', $user->user_id)
            ->get();
    }

    public function paginateForParent(User $user)
    {
        return $this->where('user_id', '=', $user->user_id)
            ->with('teacher', 'teacher.school')
            ->paginate(15)
            ->toArray();
    }

    public function getStudentsByIds($studentIds)
    {
        return $this->whereIn('student_id', $studentIds)
            ->get();
    }
}
