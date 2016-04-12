<?php

namespace Jcfk\Http\Controllers\Admin;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\Parents;
use Jcfk\Models\Role;
use Jcfk\Models\User;
use Jcfk\Validators\UserValidator;

/**
 * @Middleware("admin")
 */
class AdminUserController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @Get("/admin/user", as="admin::user.index")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * @Get("/admin/user/list", as="admin::user.list")
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $users = $this->user->leftJoin('parent', 'user.user_id', '=', 'parent.user_id')
            ->whereNull('parent.user_id')
            ->where('is_active', '=', 1)
            ->paginate(15)
            ->toArray();

        $users['columns'] = ['email'];
        $users['pk']      = ['user_id'];

        return $users;
    }

    /**
     * @Get("/admin/user/{userId}", as="admin::user.show", where={"userId": "[0-9]+"}))
     *
     * @param $userId
     * @return mixed
     */
    public function show($userId)
    {
        return $this->user->find($userId);
    }

    /**
     * @Put("/admin/user", as="admin::user.store")
     *
     * @param Request $request
     * @return Parents
     */
    public function store(Request $request, UserValidator $userValidator)
    {
        $this->validate($request, $userValidator);

        return $this->user->registerOrUpdate($request, Role::ADMIN);
    }

    /**
     * @Get("/admin/user/delete/{userId}", as="admin::user.delete")
     *
     * @param $userId
     */
    public function delete($userId)
    {
        return (string) $this->user->destroy($userId);
    }
}
