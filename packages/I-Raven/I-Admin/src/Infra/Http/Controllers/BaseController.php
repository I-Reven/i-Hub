<?php

namespace IRaven\IAdmin\Infra\Http\Controllers;

use App;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use IRaven\IAdmin\Domain\Contracts\Handlers\ExceptionHandlerContract;

/**
 * Class BaseController
 * @package IRaven\IAdmin\Infra\Http\Controllers
 */
abstract class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        App::singleton(
            ExceptionHandler::class,
            ExceptionHandlerContract::class
        );
    }
}
