<?php

namespace App\Listeners;

use moki74\BtcPayment\Events\UnknownTransactionEvent;
use Illuminate\Support\Facades\Log;

class UnknownTransactionListener
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
    public function handle(UnknownTransactionEvent $event)
    {
         Log::debug('Unknown transaction : '. $event->unknownTx);
    }
}
