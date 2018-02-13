<?php

namespace App\Models;

use Engine\Modules\Model\AbstractModel;

class OrderModel extends AbstractModel
{
    /**
     * Get all possible orders
     *
     * @return array
     */
    public function getOrders(): array
    {
        $statement = $this->getDbManager()->prepare('SELECT * FROM `Order`');
        if ($statement->execute()) {
            return $statement->fetchAll();
        }

        return [];
    }
}
