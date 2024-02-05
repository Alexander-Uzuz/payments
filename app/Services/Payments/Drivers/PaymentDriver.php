<?php

namespace App\Services\Payments\Drivers;

use Illuminate\Contracts\View\View;
use App\Services\Payments\Models\Payment;

abstract class PaymentDriver
{
    // abstract public function foo(): string;

    abstract public function view(Payment $payment): View;
}
