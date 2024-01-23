<?php

namespace App\Services\Payments\Drivers;

use App\Services\Payments\Drivers\PaymentDriver;
use App\Services\Payments\Enums\PaymentDriverEnum;

class PaymentDriverFactory
{
    public function make($driver): PaymentDriver
    {
        return match ($driver) {
            PaymentDriverEnum::test => new TestPaymentDriver,

            default => throw new \InvalidArgumentException(
                "Драйвер [{$driver}] не поддерживается"
            )
        };
    }
}