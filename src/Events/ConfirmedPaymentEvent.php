<?php

namespace moki74\BtcPayment\Events;

use moki74\BtcPayment\Models\Payment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ConfirmedPaymentEvent
{
    use SerializesModels;

    public $confirmedPayment;

    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Payment $confirmedPayment)
    {
        $this->confirmedPayment = $confirmedPayment;
        //Log::debug('Event constructor :'.$this->unconfirmedPayment);
    }
}
