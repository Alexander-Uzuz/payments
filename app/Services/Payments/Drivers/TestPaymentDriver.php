<?php

namespace App\Services\Payments\Drivers;

use Illuminate\Contracts\View\View;
use App\Services\Payments\Models\Payment;

class TestPaymentDriver extends PaymentDriver
{
    public function foo(): string
    {
        return 'bar';
    }

    public function view(Payment $payment): View
    {
        return view('payments::test', compact('payment'));
    }
}
