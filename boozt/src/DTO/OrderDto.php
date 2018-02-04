<?php

namespace App\DTO;

class OrderDto
{
    /**
     * @var int
     */
    private $resourceId;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $device;

    /**
     * @var \DateTime
     */
    private $purchaseDate;

    /**
     * @var int
     */
    private $costumerId;

    /**
     * @param array $order
     * @return static
     */
    public static function make(array $order)
    {
        $orderDto = new static();

        if (isset($order['id'])) {
            $orderDto->resourceId = $order['id'];
        }

        if (isset($order['country'])) {
            $orderDto->country = $order['country'];
        }

        if (isset($order['device'])) {
            $orderDto->device = $order['device'];
        }

        if (isset($order['purchase_date'])) {
            $orderDto->purchaseDate =  new \DateTime($order['purchase_date']);
        }

        if (isset($order['Customer_id'])) {
            $orderDto->costumerId =  new \DateTime($order['Customer_id']);
        }

        return $orderDto;
    }

    /**
     * @return int
     */
    public function getResourceId(): int
    {
        return $this->resourceId;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getDevice(): string
    {
        return $this->device;
    }

    /**
     * @return \DateTime
     */
    public function getPurchaseDate(): \DateTime
    {
        return $this->purchaseDate;
    }

    /**
     * @return int
     */
    public function getCostumerId(): int
    {
        return $this->costumerId;
    }
}
