<?php

namespace Engine\Modules\Container;

use Engine\Modules\Container\Exceptions\UnableToGetService;
use Engine\Modules\Container\Exceptions\UnableToRegisterServiceException;

class EngineContainer implements ContainerInterface
{
    /**
     * @var array
     */
    private $container = [];

    /**
     * Check if service loaded
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasService(string $name): bool
    {
        return isset($this->container[$name]) ? true : false;
    }

    /**
     * Must return registered service from container
     *
     * @param string $name
     *
     * @return mixed
     * @throws \Engine\Modules\Container\Exceptions\UnableToGetService
     */
    public function getService(string $name)
    {
        if (!isset($this->container[$name])) {
            throw new UnableToGetService($name);
        }

        return $this->container[$name];
    }

    /**
     * Must register given service to container
     *
     * @param string $name
     * @param object $service
     *
     * @return void
     * @throws \Engine\Modules\Container\Exceptions\UnableToRegisterServiceException
     */
    public function setService(string $name, object $service): void
    {
        if (\in_array($name, $this->container, true)) {
            throw new UnableToRegisterServiceException($name);
        }
        
        $this->container[$name] = $service;
    }
}