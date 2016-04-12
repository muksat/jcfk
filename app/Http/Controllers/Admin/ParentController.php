<?php

namespace Jcfk\Http\Controllers\Admin;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\Parents;
use Jcfk\Models\Role;
use Jcfk\Models\User;
use Jcfk\Validators\ParentValidator;
use Jcfk\Validators\UserValidator;

/**
 * @Middleware("admin")
 */
class ParentController extends Controller
{
    /**
     * @var Parents
     */
    private $parent;
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user, Parents $parent)
    {
        $this->parent = $parent;
        $this->user   = $user;
    }

    /**
     * @Get("/admin/parent", as="admin::parent.index")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.parent.index');
    }

    /**
     * @Get("/admin/parent/list", as="admin::parent.list")
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getList(Request $request)
    {
        $parents = $this->parent->paginateWithUsers($request->get('page', 1), 25)
            ->toArray();

        $parents['columns'] = [ 'name','email', 'phone'];
        $parents['pk']      = ['user_id'];

        return $parents;
    }

    /**
     * @Get("/admin/parent/{parentId}", as="admin::parent.show", where={"parentId": "[0-9]+"}))
     *
     * @param $parentId
     * @return mixed
     */
    public function show($parentId)
    {
        $parent = $this->parent->find($parentId);

        return array_merge($parent->toArray(), $parent->user->toArray());
    }

    /**
     * @Put("/admin/parent", as="admin::parent.store")
     *
     * @param Request $request
     * @return Parents
     */
    public function store(Request $request, ParentValidator $parentValidator)
    {
        $this->validate($request, $parentValidator);

        $parentId = $request->get('user_id');
        $input = $request->except('user_id');

        $user = $this->user->registerOrUpdate($request, Role::PARENT);

        $parent = $user->parent()->findOrNew($parentId);
        $parent->fill($input);
        $parent->save();

        return $parent;
    }

    /**
     * @Get("/admin/parent/delete/{parentId}", as="admin::parent.delete")
     *
     * @param $parentId
     */
    public function delete($parentId)
    {
        return (string) ($this->parent->destroy($parentId) && $this->user->destroy($parentId));
    }

    /**
     * @Get("/admin/parent/search/{schoolName}", as="admin::parent.search")
     *
     * @return JsonResponse
     */
    public function search($schoolName)
    {
        return $this->parent->searchByName($schoolName);
    }

    /**
     * @Get("/admin/parent/search/load/{parentId}", as="admin::parent.search.load")
     *
     * @param $schoolId
     * @return Parents
     */
    public function load($parentId)
    {
        return $this->show($parentId);
    }
}
