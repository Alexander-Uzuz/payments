<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Services\Payments\Models\Payment;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Payment $payment, PaymentService $paymentService)
    {
        abort_unless($payment->status->isPending(), 404);

        $methods = $paymentService
        ->getPaymentMethods()
        ->active(true)
        ->run();

        return view('payments.checkout', compact('payment', 'methods'));
    }

    public function method(
        UpdatePaymentRequest $request,
        PaymentService $paymentService,
        Payment $payment
    )
    {
        abort_unless($payment->status->isPending(), 404);

        $validated = $request->validated();

        $method = $paymentService
            ->findPaymentMethod()
            ->id($validated['method_id'])
            ->active(true)
            ->run();


        $paymentService
            ->updatePayment()
            ->method($method)
            ->run($payment);

        return redirect()->route('payments.process', $payment->uuid);
    }

    public function process(Payment $payment)
    {
        abort_unless($payment->status->isPending(), 404);

        return 'Оплата выбранным способом ' . $payment->method->name;
    }
}
