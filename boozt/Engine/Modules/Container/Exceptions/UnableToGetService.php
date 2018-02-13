<?php

namespace Engine\Modules\Container\Exceptions;

use Engine\Exceptions\EngineExceptionInterface;
use Throwable;

class UnableToGetService extends \RuntimeException implements EngineExceptionInterface
{
    public function __construct(string $service = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Unable to get service(%s) from engine container', $service), $code, $previous);
    }
}
