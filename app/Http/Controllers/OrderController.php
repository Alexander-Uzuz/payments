<?php

namespace App\Http\Controllers;

use App\Services\Orders\Models\Order;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function payment(Order $order, PaymentService $paymentService)
    {
        $payment = $paymentService
            ->createPayment()
            ->payable($order)
            ->run();

        return to_route('payments.checkout', $payment->uuid);
    }
}
