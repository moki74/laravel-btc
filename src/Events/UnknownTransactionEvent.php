<?php

namespace moki74\LaravelBtc\Events;

use moki74\LaravelBtc\Models\UnknownTransaction;
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
        //Log::debug('UnknownTransaction Event constructor :'.$this->$unknownTx);
    }
}
