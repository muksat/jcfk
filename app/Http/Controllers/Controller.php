<?php

namespace Jcfk\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Jcfk\Validators\CustomValidatesRequest;

abstract class Controller extends BaseController
{
    use DispatchesJobs, CustomValidatesRequest;
}
