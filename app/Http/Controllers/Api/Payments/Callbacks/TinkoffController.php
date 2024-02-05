<?php

namespace App\Http\Controllers\Api\Payments\Callbacks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Tinkoff\TinkoffService;
use App\Services\Payments\PaymentService;
use Carbon\Exceptions\InvalidTypeException;
use App\Services\Tinkoff\Enums\PaymentStatusEnum;

class TinkoffController extends Controller
{
    public function __invoke(
        Request $request,
        PaymentService $paymentService,
        TinkoffService $tinkoffService,
    ) {
        try {
            $entity = $tinkoffService->checkCallback($request->all());

            $payment = $paymentService->getPayments()->uuid($entity->order)->first();


            match ($entity->status) {
                PaymentStatusEnum::CONFIRMED => $paymentService->completePayment()->run($payment),
                PaymentStatusEnum::REJECTED => $paymentService->cancelPayment()->run($payment),
                PaymentStatusEnum::CANCELED => $paymentService->cancelPayment()->run($payment),
                PaymentStatusEnum::REVERSED => $paymentService->cancelPayment()->run($payment),
                PaymentStatusEnum::REFUNDED => $paymentService->cancelPayment()->run($payment),
                default => null,
            };
        } catch (InvalidTypeException $e) {
            report($e);
        }
    }
}
