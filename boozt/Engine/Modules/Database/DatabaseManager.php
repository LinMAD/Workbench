<?php

namespace Engine\Modules\Database;

class DatabaseManager extends \PDO
{
    /**
     * DatabaseManager constructor.
     *
     * @param AbstractDbConfig $dbConfig
     */
    public function __construct(AbstractDbConfig $dbConfig)
    {
        parent::__construct(
            sprintf(
                'mysql:host=%s;dbname=%s;',
                $dbConfig->getDbHost(),
                $dbConfig->getDbName()
            ),
            $dbConfig->getDbUser(),
            $dbConfig->getDbPassword(),
            $dbConfig->getDriverSettings()
        );

        if ($dbConfig->isDebug()) {
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }
}
