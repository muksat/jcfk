<?php

namespace Jcfk\Http\Controllers\Parent;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Jcfk\Http\Controllers\Controller;

/**
 * @Middleware("parent")
 */
class DashboardController extends Controller
{
    /**
     * @Get("/parent", as="parent::dashboard")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('parent.dashboard');
    }
}
