<?php

namespace App\Listeners;

use moki74\LaravelBtc\Events\ConfirmedPaymentEvent;
use Illuminate\Support\Facades\Log;

class ConfirmedPaymentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ConfirmedPaymentEvent  $event
     * @return void
     */
    public function handle(ConfirmedPaymentEvent $event)
    {
        Log::debug('Confirmed Payment listener: '. $event->confirmedPayment);
    }
}
