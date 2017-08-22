<?php

namespace moki74\BtcPayment\Events;

use moki74\BtcPayment\Models\Payment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UnconfirmedPayment
{
    use SerializesModels;

    public $unconfirmedPayment;

    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Payment $unconfirmedPayment)
    {
        $this->unconfirmedPayment = $unconfirmedPayment;
        //Log::debug('Event constructor :'.$this->unconfirmedPayment);
    }
}
