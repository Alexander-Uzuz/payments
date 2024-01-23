<?php

namespace App\Services\Payments\Actions;

use Illuminate\Support\Str;
use App\Services\Payments\Models\Payment;
use App\Services\Payments\Contracts\Payable;
use App\Services\Payments\Enums\PaymentStatusEnum;

class CreatePaymentAction
{
    private readonly Payable $payable;

    public function payable(Payable $payable): static
    {
        $this->payable = $payable;

        return $this;
    }

    public function run(): Payment
    {
        return Payment::query()
        ->create([
            'uuid' => (string) Str::uuid(),
            'status' => PaymentStatusEnum::pending,
            'currency_id' => $this->payable->getPayableCurrencyId(),
            'amount' => $this->payable->getPayableAmount(),
            'payable_type' => $this->payable->getPayableType(),
            'payable_id' => $this->payable->getPayableId(),
            'method_id' => null,
            'driver' => null,
        ]);
    }
}
