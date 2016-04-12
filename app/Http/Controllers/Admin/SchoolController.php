<?php

namespace Jcfk\Http\Controllers\Admin;

use Collective\Annotations\Routing\Annotations\Annotations\Delete;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\School;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Middleware("admin")
 */
class SchoolController extends Controller
{
    /**
     * @var School
     */
    private $school;

    public function __construct(School $school)
    {
        $this->school = $school;
    }

    /**
     * @Get("/admin/school", as="admin::school.index")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.school.index');
    }

    /**
     * @Get("/admin/school/list", as="admin::school.list")
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $schools = $this->school->paginate(30)
            ->toArray();

        $schools['columns'] = ['name', 'phone','city_name'];
        $schools['pk']      = ['school_id'];

        return $schools;
    }

    /**
     * @Get("/admin/school/{schoolId}", as="admin::school.show", where={"schoolId": "[0-9]+"}))
     *
     * @param $schoolId
     * @return mixed
     */
    public function show($schoolId)
    {
        return $this->school->find($schoolId);
    }

    /**
     * @Put("/admin/school", as="admin::school.store")
     *
     * @param Request $request
     * @return School
     */
    public function store(Request $request)
    {
        //TODO: inputs comes with a _token, its should be possbile to hide the _token for ajax requests
        $schoolId = $request->get('school_id');
        $input = $request->all();

        /** @var School $school */
        $school = $this->school->findOrNew($schoolId);

        $school->fill($input);
        $school->save();

        return $school;
    }

    /**
     * @Get("/admin/school/delete/{schoolId}", as="admin::school.delete")
     *
     * @param $schoolId
     */
    public function delete($schoolId)
    {
        return (string) $this->school->destroy($schoolId);
    }

    /**
     * @Get("/admin/school/search/{schoolName}", as="admin::school.search")
     *
     * @return JsonResponse
     */
    public function search($schoolName)
    {
        return $this->school->searchByName($schoolName);
    }

    /**
     * @Get("/admin/school/search/load/{schoolId}", as="admin::school.search.load")
     *
     * @param $schoolId
     * @return School
     */
    public function load($schoolId)
    {
        return $this->show($schoolId);
    }
}
