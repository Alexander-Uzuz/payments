<?php

namespace App\Services\Payments\Models;

use App\Services\Payments\Enums\PaymentDriveEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'active',
        'driver',
    ];

    protected $casts = [
        'active' => 'boolean',
        'driver' => PaymentDriveEnum::class,
    ];
}
