<?php

namespace Jcfk\Http\Controllers\Parent;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\Student;
use Jcfk\Validators\StudentValidator;

/**
 * @Middleware("parent")
 */
class StudentController extends Controller
{
    /**
     * @var Student
     */
    private $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * @Get("/parent/student", as="parent::student")
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('parent.student.index');
    }

    /**
     * @Get("/parent/student/list", as="parent::student.list")
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getList(Guard $auth)
    {
        $students = $this->student->paginateForParent($auth->user());

        $students['columns'] = ['name', 'teacher_name', 'school_name'];
        $students['pk']      = ['student_id'];

        return $students;
    }

    /**
     * @Get("/parent/student/{studentId}", as="parent::student.show")
     *
     * @param $studentId
     * @return mixed
     */
    public function show($studentId)
    {
        return $this->student->find($studentId);
    }

    /**
     * @Put("/parent/student", as="parent::student.store")
     *
     * @param Request $request
     * @return Student
     */
    public function store(Request $request, Guard $auth, StudentValidator $studentValidator)
    {
        $this->validate($request, $studentValidator);

        $input = $request->only('name', 'teacher_id');

        $student = new Student();
        $student->fill($input);
        $student->user_id = $auth->user()->user_id;
        $student->save();

        return $student;
    }
}
