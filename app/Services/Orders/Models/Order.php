<?php

namespace App\Services\Orders\Models;

use Illuminate\Support\Carbon;
use App\Support\Values\AmountValue;
use Illuminate\Database\Eloquent\Model;
use App\Services\Currencies\Models\Currency;
use App\Services\Payments\Contracts\Payable;
use App\Services\Orders\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $uuid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property OrderStatusEnum $status
 * @property Currency $currency_id
 * @property AmountValue $amount
 */
class Order extends Model implements Payable
{
    use HasFactory;

    protected $fillable = [
        'status',
        'currency_id', 'amount',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class,
        'amount' => AmountValue::class,
    ];

    public function getPayableName(): string
    {
        return "Заказ {$this->uuid}";
    }

    public function getPayableCurrencyId(): string
    {
        return $this->currency_id;
    }

    public function getPayableAmount(): AmountValue
    {
        return $this->amount;
    }

    public function getPayableType(): string
    {
        return $this->getMorphClass();
    }

    public function getPayableId(): int
    {
        return $this->id;
    }

    public function getPayableUrl(): string
    {
        return route('orders.show', $this->uuid);
    }
}
