<?php

namespace Engine;

use Engine\Modules\Container\ContainerInterface;
use Engine\Modules\Container\EngineContainer;

class Core
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(?ContainerInterface $container = null)
    {
        $this->container = $container ?: new EngineContainer();
    }

    public function test()
    {
        $this->container->setService('foo', new \stdClass());

        return $this->container;
    }
}
