<?php

namespace App\Services\Payments;

use App\Services\Payments\Models\PaymentMethod;
use App\Services\Payments\Drivers\PaymentDriver;
use App\Services\Payments\Enums\PaymentDriverEnum;
use App\Services\Payments\Drivers\TestPaymentDriver;

class PaymentService
{
    public function getDriver(PaymentMethod $method): PaymentDriver
    {
        return match($method->driver){
            PaymentDriverEnum::test => new TestPaymentDriver,

            default => throw new \InvalidArgumentException(
                "Драйвер [{$method->driver}] не поддерживается"
            )
        };
    }
}
