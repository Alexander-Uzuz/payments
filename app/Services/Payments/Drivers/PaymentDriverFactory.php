<?php

namespace App\Services\Payments\Drivers;

use App\Services\Payments\Drivers\PaymentDriver;
use App\Services\Payments\Drivers\TinkoffDriver;
use App\Services\Payments\Enums\PaymentDriverEnum;
use App\Services\Payments\Drivers\StripeElementsDriver;

class PaymentDriverFactory
{
    public function make($driver): PaymentDriver
    {
        return match ($driver) {
            PaymentDriverEnum::test => app(TestPaymentDriver::class),
            PaymentDriverEnum::tinkoff => app(TinkoffDriver::class),
            PaymentDriverEnum::stripe_elements => app(StripeElementsDriver::class),


            default => throw new \InvalidArgumentException(
                "Драйвер [{$driver}] не поддерживается"
            )
        };
    }
}
