<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMessageAdmin
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        Message::create([
            'name' => 'Nová objednávka-',
            'about' => 'order',
            'about_id' => $event->order->id,
            'content' => 'Zákazník '. auth()->user()->name .' si objednal tovar.'
        ]);
    }
}
