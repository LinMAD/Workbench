<?php

namespace Engine;

use Engine\Modules\Container\ContainerInterface;
use Engine\Modules\Container\EngineContainer;
use Engine\Modules\Database\AbstractDbConfig;
use Engine\Modules\Database\DatabaseManager;
use Engine\Modules\Router\Router;
use Engine\Modules\Router\RouterInterface;

class Core
{
    // TODO If service loader will be implemented, remove const names of services
    public const SERV_DB = 'db';
    private const SERV_ROUTER = 'router';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Builds core of engine with given DI
     *
     * @param AbstractDbConfig $dbConfig
     * @param RouterInterface|null $router
     * @param ContainerInterface|null $container
     */
    public function __construct(
        AbstractDbConfig $dbConfig,
        ?RouterInterface $router = null,
        ?ContainerInterface $container = null
    ) {
        $this->container = $container ?: new EngineContainer();

        // TODO Think about service loader if will have a time
        // TODO Add database manager to abstract model
        // TODO add percona
        $this->container->setService(self::SERV_DB, new DatabaseManager($dbConfig));
        $this->container->setService(self::SERV_ROUTER, $router ?: new Router());
    }

    /**
     * Return instance of engine container
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Return router module
     *
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->container->getService(self::SERV_ROUTER);
    }

    /**
     * Return database manager module
     *
     * @return DatabaseManager
     */
    public function getDatabaseManager(): DatabaseManager
    {
        return $this->container->getService(self::SERV_DB);
    }

    /**
     * Execute engine, to handle HTTP requests
     *
     * @throws \Engine\Modules\Router\Exceptions\RoutesNotFoundException
     * @throws \Engine\Modules\Router\Exceptions\NotFoundException
     */
    public function run(): void
    {
        $this->container->getService(self::SERV_ROUTER)::execute($_SERVER['REQUEST_URI']);
    }
}
