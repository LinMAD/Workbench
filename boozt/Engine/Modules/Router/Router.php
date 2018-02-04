<?php

namespace Engine\Modules\Router;

use Engine\Modules\Router\Exceptions\InvalidRouteConfigurationException;
use Engine\Modules\Router\Exceptions\NotFoundException;
use Engine\Modules\Router\Exceptions\RoutesNotFoundException;

class Router implements RouterInterface
{
    /**
     * Routes collection
     *
     * @var array
     */
    private static $routes = [];

    /**
     * Construct route with pattern and callback code
     *
     * @param string $pattern
     * @param $callback
     * @throws \Engine\Modules\Router\Exceptions\InvalidRouteConfigurationException
     */
    public function addRoute(string $pattern, $callback): void
    {
        if (!\is_callable($callback)) {
            throw new InvalidRouteConfigurationException(
                'Second argument of ' . __METHOD__ . ' must be callable'
            );
        }

        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

        self::$routes[$pattern] = $callback;
    }

    /**
     * Execute the request
     *
     * @example Router::execute($_SERVER['REQUEST_URI']);
     *
     * @param string $url
     *
     * @return mixed
     *
     * @throws \Engine\Modules\Router\Exceptions\NotFoundException
     * @throws \Engine\Modules\Router\Exceptions\RoutesNotFoundException
     */
    public static function execute(string $url)
    {
        if (\count(self::$routes) <= 0) {
            throw new RoutesNotFoundException('Routes collection are empty');
        }

        foreach (self::$routes as $pattern => $callback) {
            if (preg_match($pattern, $url, $params)) {
                array_shift($params);

                return \call_user_func_array($callback, array_values($params));
            }
        }

        throw new NotFoundException();
    }
}