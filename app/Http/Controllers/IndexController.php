<?php

namespace Jcfk\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;

/**
 * @Middleware("guest")
 */
class IndexController extends Controller
{
    /**
     * @Get("/", as="homepage")
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }
}
