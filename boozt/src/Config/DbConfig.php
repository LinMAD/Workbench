<?php

namespace App\Config;

use Engine\Modules\Database\AbstractDbConfig;

final class DbConfig extends AbstractDbConfig
{
    /**
     * Database configuration
     *
     * @param string $dbHost
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPass
     */
    public function __construct(string $dbHost ,string $dbName, string $dbUser, string $dbPass)
    {
        $this->setDatabaseCharSet(); // set default charset for db

        parent::__construct($dbHost, $dbName, $dbUser, $dbPass);
    }

    /**
     * Set db charset
     *
     * @param string $encoding
     */
    public function setDatabaseCharSet(string $encoding = 'UTF8')
    {
        $this->driverSettings[\PDO::MYSQL_ATTR_INIT_COMMAND] = sprintf('SET NAMES %s', $encoding);
    }
}
