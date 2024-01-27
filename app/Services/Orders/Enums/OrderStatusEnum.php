<?php

namespace App\Services\Orders\Enums;

enum OrderStatusEnum: string
{
    case pending = 'pending';
    case completed = 'completed';
    case canceled = 'canceled';

    public function name(): string
    {
        return match ($this) {
            self::pending => 'Ожидает',
            self::completed => 'Завершено',
            self::canceled => 'Отменено',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::pending => 'warning',
            self::completed => 'success',
            self::canceled => 'danger',
        };
    }

    public function is(OrderStatusEnum $status):bool
    {
        return $this === $status;
    }

    public function isPending()
    {
        return $this->is(self::pending);
    }
}
