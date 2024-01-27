<?php

namespace App\Services\Payments\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Services\Payments\Events\PaymentCancelledData;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PaymentCancelledEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public PaymentCancelledData $data,
    )
    {}
}
