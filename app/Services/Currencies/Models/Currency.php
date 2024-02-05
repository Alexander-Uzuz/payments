<?php

namespace App\Services\Currencies\Models;

use App\Support\Values\AmountValue;
use Illuminate\Database\Eloquent\Model;
use App\Services\Currencies\Sources\SourceEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @property string $id
 * @property string $name
 */

class Currency extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id', 'name',
        'price', 'source',
    ];

    protected $casts = [
        'price' => AmountValue::class,
        'source' => SourceEnum::class,
    ];

    public const RUB = 'RUB';
    public const USD = 'USD';
}
