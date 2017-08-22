<?php

namespace moki74\BtcPayment\Events;

use moki74\BtcPayment\Models\UnknownTransaction;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UnknownTransactionEvent
{
    use SerializesModels;

    public $unknownTx;

    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(UnknownTransaction $unknownTx)
    {
        $this->unknownTx = $unknownTx;
    }
}
