<?php

namespace moki74\LaravelBtc\Events;

use moki74\LaravelBtc\Models\Payment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ConfirmedPaymentEvent
{
    use SerializesModels;

    public $confirmedPayment;

    /**
     * Fired when num of confirmations on block chain meet BITCOIND_MIN_CONFIRMATIONS in .env file.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Payment $confirmedPayment)
    {
        $this->confirmedPayment = $confirmedPayment;
        //Log::debug('ConfirmedPaymentEvent constructor :'.$this->confirmedPayment);
    }
}
