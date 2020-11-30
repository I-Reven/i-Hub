<?php

namespace IRaven\Hexagonal\Application\Handlers;

use App\Exceptions\Handler;
use IRaven\Hexagonal\Domain\Contracts\Handlers\ExceptionHandlerContract;
use IRaven\Hexagonal\Domain\Exceptions\PingWriteException;
use Log;

/**
 * Class ExceptionHandler
 * @package IRaven\Hexagonal\Application\Handlers
 */
class ExceptionHandler extends Handler implements ExceptionHandlerContract
{
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (PingWriteException $e) {
            Log::error($e->getMessage(), $e->getTrace());
        });

        parent::register();
    }
}
