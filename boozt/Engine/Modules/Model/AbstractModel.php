<?php

namespace Engine\Modules\Model;

use Engine\Modules\Database\DatabaseManager;

class AbstractModel
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * AbstractModel constructor.
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Return database manager
     *
     * @return DatabaseManager
     */
    protected function getDbManager(): DatabaseManager
    {
        return $this->databaseManager;
    }
}
