<?php

namespace App\View\Orders;

use App\DTO\OrderDto;
use App\View\ViewBuilder;

class OrderViewBuilder extends ViewBuilder
{
    /**
     * @var OrderDto[]
     */
    private $orders = [];

    public function __construct(array $orders)
    {
        foreach ($orders as $order) {
            $this->orders[] = OrderDto::make($order);
        }
    }

    /**
     * @param string $body
     * @return $this|void
     */
    public function addBody(string $body)
    {
        if (\count($this->orders) <= 0) {
            return;
        }

        /** @var OrderDto $order */
        foreach ($this->orders as $order) {
            $this->pageBody .= '<h1>' . $order->getCostumerId() . ' - ' . $order->getDevice() . '</h1>';
            $this->pageBody .= '<h5>' . $order->getPurchaseDate()->format('Y-m-d') . '</h5>';
        }
    }
}