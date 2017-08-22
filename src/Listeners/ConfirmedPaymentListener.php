<?php

namespace App\Listeners;

use moki74\BtcPayment\Events\ConfirmedPayment;
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
     * @param  OrderShipped  $event
     * @return void
     */
    public function handle(ConfirmedPayment $event)
    {
         Log::debug('Confirmed Payment listener: '. $event->confirmedPayment);
    }
}
