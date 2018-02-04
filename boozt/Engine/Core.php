<?php

namespace Engine;

use Engine\Modules\Container\ContainerInterface;
use Engine\Modules\Container\EngineContainer;
use Engine\Modules\Database\AbstractDbConfig;
use Engine\Modules\Database\DatabaseManager;

class Core
{
    // TODO If service loader will be implemented, remove const names of services
    public const SERV_DB = 'db';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Builds core of engine with given DI
     *
     * @param AbstractDbConfig $dbConfig
     * @param ContainerInterface|null $container
     */
    //public function __construct(AbstractDbConfig $dbConfig, ?ContainerInterface $container = null)
    public function __construct(?ContainerInterface $container = null)
    {
        $this->container = $container ?: new EngineContainer();

        // TODO Think about service loader if will have a time
        // TODO Add database manager to abstract model
        // TODO add percona and pdo to php image
        //$this->container->setService(self::SERV_DB, new DatabaseManager($dbConfig));
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
}
