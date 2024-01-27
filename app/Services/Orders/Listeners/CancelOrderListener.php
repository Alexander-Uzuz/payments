<?php

namespace App\Services\Orders\Listeners;

use App\Services\Orders\Models\Order;
use App\Services\Orders\OrderService;
use App\Services\Payments\Events\PaymentCancelledEvent;

class CancelOrderListener
{
    public function __construct(
        private OrderService $orderService,
    )
    {}

    public function handle(PaymentCancelledEvent $event): void
    {
        $payableType = $event->data->payableType;
        $payableId = $event->data->payableId;

        if($payableType !== (new Order)->getPayableType()) return;
        if($order = Order::query()->find($payableId)) $this->orderService->cancelOrder()->run($order);
    }
}
