<?php

namespace App\Listeners;

use moki74\BtcPayment\Events\UnconfirmedPayment;
use Illuminate\Support\Facades\Log;

class UnconfirmedPaymentListener
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
    public function handle(UnconfirmedPayment $event)
    {
         Log::debug('Unconfirmed Payment listener: '. $event->unconfirmedPayment);
    }
}
