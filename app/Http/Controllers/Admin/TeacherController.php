<?php
namespace Jcfk\Http\Controllers\Admin;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\Teacher;
use Jcfk\Http\Requests;
use Jcfk\Validators\TeacherValidator;

/**
 * @Middleware("admin")
 */class TeacherController extends Controller
{
    /**
     * @var $teacher
     */
    private $teacher;

    public function __construct(Teacher $teacher)
    {
        $this->teacher=$teacher;
    }
    /**
     * @Get("/admin/teacher", as="admin::teacher.index")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.teacher.index');
    }
    /**
     * @Get("/admin/teacher/list", as="admin::teacher.list")
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getList()
    {
        $teachers = $this->teacher->paginate(25)
            ->toArray();
        $teachers['columns'] = ['name','school_name','room'];
        $teachers['pk']      = ['teacher_id'];
        return $teachers;
    }

    /**
     * @Get("/admin/teacher/{teacherId}", as="admin::teacher.show")
     *
     * @param $teacherId
     * @return mixed
     */
    public function show($teacherId)
    {
        return $this->teacher->find($teacherId);
    }

    /**
     * @Put("/admin/teacher", as="admin::teacher.store")
     *
     * @param Request $request
     * @return teacher
     */
    public function store(Request $request, TeacherValidator $teacherValidator)
    {
        $this->validate($request, $teacherValidator);

        $teacherId = $request->get('teacher_id');
        $input    = $request->all();

        /** @var teacher $teacher */
        $teacher = $this->teacher->findOrNew($teacherId);

        $teacher->fill($input);
        $teacher->save();

        return $teacher;
    }

    /**
     * @Get("/admin/teacher/delete/{teacherId}", as="admin::teacher.delete")
     *
     * @param $teacherId
     */
    public function delete($teacherId)
    {
        return (string) $this->teacher->destroy($teacherId);
    }
}
