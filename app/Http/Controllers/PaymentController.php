<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Payments\Models\Payment;
use App\Services\Payments\PaymentService;
use App\Http\Requests\Payment\UpdatePaymentRequest;

class PaymentController extends Controller
{
    public function checkout(Payment $payment, PaymentService $paymentService)
    {
        abort_unless($payment->status->isPending(), 404);

        $methods = $paymentService
            ->getPaymentMethods()
            ->active()
            ->get();

        return view('payments.checkout', compact('payment', 'methods'));
    }

    public function method(
        UpdatePaymentRequest $request,
        PaymentService $paymentService,
        Payment $payment
    ) {
        abort_unless($payment->status->isPending(), 404);

        $validated = $request->validated();

        $method = $paymentService
            ->getPaymentMethods()
            ->id($validated['method_id'])
            ->active()
            ->first();


        $paymentService
            ->updatePayment()
            ->method($method)
            ->run($payment);

        return redirect()->route('payments.process', $payment->uuid);
    }

    public function process(Payment $payment, PaymentService $paymentService)
    {
        abort_unless($payment->status->isPending(), 404);
        abort_unless($payment->method_id, 404);

        $driver = $paymentService->getDriver($payment->driver);

        return $driver->view($payment);
    }

    public function complete(Payment $payment, PaymentService $paymentService)
    {
        abort_unless($payment->status->isPending(), 404);
        abort_unless($payment->driver->isTest(), 404);
        abort_if(app()->isProduction(), 404);

        $paymentService->completePayment()->run($payment);

        return redirect()->route('payments.success', [
            'uuid' => $payment->uuid,
        ]);
    }

    public function cancel(Payment $payment, PaymentService $paymentService)
    {
        abort_unless($payment->status->isPending(), 404);
        abort_unless($payment->driver->isTest(), 404);
        abort_if(app()->isProduction(), 404);

        $paymentService->cancelPayment()->run($payment);

        return redirect()->route('payments.failure', [
            'uuid' => $payment->uuid,
        ]);
    }

    public function success(
        Request $request,
        Payment $payment,
        PaymentService $paymentService,
    ) {
        $uuid = $request->uuid;

        abort_unless(Str::isUuid($uuid), 404);

        $payment = $paymentService
            ->getPayments()
            ->uuid($uuid)
            ->first();

        abort_unless($payment, 404);

        return view('payments.success', compact('payment'));
    }


    public function failure(
        Request $request,
        Payment $payment,
        PaymentService $paymentService,
    ) {
        $uuid = $request->uuid;

        abort_unless(Str::isUuid($uuid), 404);

        $payment = $paymentService
            ->getPayments()
            ->uuid($uuid)
            ->first();

        abort_unless($payment, 404);

        return view('payments.failure', compact('payment'));
    }
}
