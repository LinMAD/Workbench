<?php

namespace Engine\Modules\Database;

abstract class AbstractDbConfig
{
    /**
     * @var string
     */
    private $dbHost;

    /**
     * @var string
     */
    private $dbName;

    /**
     * @var string
     */
    private $dbUser;

    /**
     * @var string
     */
    private $dbPassword;

    /**
     * Database driver settings
     *
     * @var array
     */
    protected $driverSettings;

    /**
     * Show database errors
     *
     * @var bool
     */
    private $debug = false;

    /**
     * AbstractDbConfig constructor.
     * @param string $dbHost
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPass
     */
    public function __construct(string $dbHost, string $dbName, string $dbUser, string $dbPass)
    {
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPass;
        $this->dbHost = $dbHost;
    }

    /**
     * Returns database settings
     *
     * @return mixed
     */
    public function getDriverSettings()
    {
        return $this->driverSettings;
    }

    /**
     * @return string
     */
    public function getDbHost(): string
    {
        return $this->dbHost;
    }

    /**
     * @return string
     */
    public function getDbName(): string
    {
        return $this->dbName;
    }

    /**
     * @return string
     */
    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    /**
     * @return string
     */
    public function getDbPassword(): string
    {
        return $this->dbPassword;
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     */
    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }
}