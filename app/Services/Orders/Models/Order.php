<?php

namespace App\Services\Orders\Models;

use Illuminate\Support\Carbon;
use App\Support\Values\AmountValue;
use Illuminate\Database\Eloquent\Model;
use App\Services\Currencies\Models\Currency;
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
class Order extends Model
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
}
