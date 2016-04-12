<?php

namespace Jcfk\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Jcfk\Models\Teacher;

/**
 * @Middleware("auth")
 */
class TeacherController extends Controller
{
    /**
     * @var Teacher
     */
    private $teacher;

    public function __construct(Teacher $teacher)
    {
        $this->teacher = $teacher;
    }

    /**
     * @Get("/teacher/{teacherName}", as="teacher.search")
     *
     * @param $teacherName
     */
    public function search($teacherName)
    {
        $teachers = $this->teacher->search($teacherName);

        $teachers->load('school');

        $response = [];

        foreach ($teachers as $teacher) {
            $response[] = [
                'teacher_id' => $teacher->teacher_id,
                'name'       => sprintf('%s (%s)', $teacher->name, $teacher->school->name)
            ];
        }

        return response()->json($response);
    }

    /**
     * @Get("/teacher/load/{teacherId}", as="teacher.load")
     *
     * @param $teacherId
     */
    public function load($teacherId)
    {
        $teacher = $this->teacher->find($teacherId);

        $teacher->load('school');

        $response = [
            'teacher_id' => $teacher->teacher_id,
            'name'       => sprintf('%s (%s)', $teacher->name, $teacher->school->name)
        ];

        return response()->json($response);
    }
}
