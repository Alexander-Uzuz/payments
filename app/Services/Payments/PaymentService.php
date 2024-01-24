<?php

namespace App\Services\Payments;

use App\Services\Payments\Drivers\PaymentDriver;
use App\Services\Payments\Enums\PaymentDriverEnum;
use App\Services\Payments\Actions\CreatePaymentAction;
use App\Services\Payments\Actions\UpdatePaymentAction;
use App\Services\Payments\Drivers\PaymentDriverFactory;
use App\Services\Payments\Actions\FindPaymentMethodAction;
use App\Services\Payments\Actions\GetPaymentMethodsAction;

class PaymentService
{
    public function getDriver(PaymentDriverEnum $driver): PaymentDriver
    {
        return (new PaymentDriverFactory)->make($driver);
    }

    public function createPayment(): CreatePaymentAction
    {
        return new CreatePaymentAction;
    }

    public function getPaymentMethods(): GetPaymentMethodsAction
    {
        return new GetPaymentMethodsAction;
    }

    public function findPaymentMethod(): FindPaymentMethodAction
    {
        return new FindPaymentMethodAction;
    }

    public function updatePayment(): UpdatePaymentAction
    {
        return new UpdatePaymentAction;
    }
}
