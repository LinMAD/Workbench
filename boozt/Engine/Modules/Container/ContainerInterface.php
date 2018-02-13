<?php

namespace Engine\Modules\Container;

interface ContainerInterface
{
    /**
     * Must return registered service from container
     *
     * @param string $service
     *
     * @return mixed
     */
    public function getService(string $service);

    /**
     * @param string $service
     * @param object $object
     *
     * @return void
     */
    public function setService(string $service, object $object): void;
}
