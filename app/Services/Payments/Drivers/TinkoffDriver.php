<?php

namespace App\Services\Payments\Drivers;

use Illuminate\Contracts\View\View;
use App\Services\Tinkoff\TinkoffConfig;
use App\Services\Tinkoff\TinkoffService;
use App\Services\Payments\Models\Payment;
use App\Services\Tinkoff\Actions\CreatePaymentData;

class TinkoffDriver extends PaymentDriver
{
    public function __construct(
        private TinkoffService $tinkoffService,
    ) {
    }

    public function view(Payment $payment): View
    {


        $entity = $this->tinkoffService->createPayment(
            new CreatePaymentData(
                amount: $payment->amount->value() * 100,
                order: $payment->uuid,
                successUrl: route('payments.success', ['uuid' => $payment->uuid]),
                failureUrl: route('payments.failure', ['uuid' => $payment->uuid]),
                callbackUrl: route('api.payments.callbacks.tinkoff'),
            ),
        );

        $payment->update(['driver_payment_id' => $entity->id]);

        return view('payments::tinkoff', compact('payment', 'entity'));
    }
}
