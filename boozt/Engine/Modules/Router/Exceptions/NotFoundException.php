<?php

namespace Engine\Modules\Router\Exceptions;

use Engine\Exceptions\EngineExceptionInterface;
use Throwable;

class NotFoundException extends \RuntimeException implements EngineExceptionInterface
{
    public function __construct(string $message = 'Page not found', int $code = 0, Throwable $previous = null)
    {
        header('HTTP/1.0 404 Not Found');

        parent::__construct($message, $code, $previous);
    }
}
