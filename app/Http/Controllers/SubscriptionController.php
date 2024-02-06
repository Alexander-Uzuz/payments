<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Payments\PaymentService;
use App\Services\Subscriptions\Enums\SubscriptionStatusEnum;
use App\Services\Subscriptions\Models\Subscription;
use App\Support\Values\AmountValue;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::query()
            ->latest('id')
            ->get();

        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        return view('subscriptions.create');
    }

    public function store(PaymentService $paymentService)
    {
        /**@var Subscription */
        $subscription = Subscription::query()
            ->create([
                'uuid' => (string) Str::uuid(),
                'price' => new AmountValue(rand(100, 1000)),
                'status' => SubscriptionStatusEnum::pending,
                'currency_id' => currency(),
            ]);

        $payment = $paymentService
            ->createPayment()
            ->payable($subscription)
            ->run();


        return to_route('payments.checkout', $payment->uuid);
    }

    public function show(Subscription $subscription)
    {
        return view('subscriptions.show', compact('subscription'));
    }

    public function payment(
        Subscription $subscription,
        PaymentService $paymentService
    ) {
        abort_unless($subscription->status->isPending(), 404);

        $payment = $paymentService
            ->createPayment()
            ->payable($subscription)
            ->run();

        return to_route('payments.checkout', $payment->uuid);
    }
}
