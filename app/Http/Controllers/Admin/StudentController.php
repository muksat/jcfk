<?php

namespace Jcfk\Http\Controllers\Admin;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\Student;
use Jcfk\Http\Requests;
use Jcfk\Validators\StudentValidator;

/**
 * @Middleware("admin")
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
     * @Get("/admin/student", as="admin::student.index")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.student.index');
    }

    /**
     * @Get("/admin/student/list", as="admin::student.list")
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $students = $this->student->with('teacher', 'teacher.school')
            ->paginate(25)
            ->toArray();

        $students['columns'] = ['name', 'teacher_name', 'school_name', 'parent_name'];
        $students['pk']      = ['student_id'];

        return $students;
    }

    /**
     * @Get("/admin/student/{studentId}", as="admin::student.show")
     *
     * @param $studentId
     * @return mixed
     */
    public function show($studentId)
    {
        return $this->student->find($studentId);
    }

    /**
     * @Put("/admin/student", as="admin::student.store")
     *
     * @param Request $request
     * @return Student
     */
    public function store(Request $request, StudentValidator $studentValidator)
    {
        $this->validate($request, $studentValidator);
        $studentId = $request->get('student_id');
        $input    = $request->all();

        /** @var student $student */
        $student = $this->student->findOrNew($studentId);

        $student->fill($input);
        $student->save();

        return $student;
    }

    /**
     * @Get("/admin/student/delete/{studentId}", as="admin::student.delete")
     *
     * @param $studentId
     */
    public function delete($studentId)
    {
        return (string) $this->student->destroy($studentId);
    }
}
