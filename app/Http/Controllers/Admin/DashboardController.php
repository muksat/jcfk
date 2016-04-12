<?php

namespace Jcfk\Http\Controllers\Admin;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Jcfk\Http\Controllers\Controller;

/**
 * @Middleware("admin")
 */
class DashboardController extends Controller
{
    /**
     * @Get("/admin", as="admin::dashboard")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
