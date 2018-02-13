<?php

namespace Engine\Modules\Router;

interface RouterInterface
{
    /**
     * Method must construct route
     *
     * @param string $pattern
     *
     * @param $callback
     *
     * @return mixed
     */
    public function addRoute(string $pattern, $callback);

    /**
     * Method must handle request
     *
     * @param string $url
     *
     * @return mixed
     */
    public static function execute(string $url);
}