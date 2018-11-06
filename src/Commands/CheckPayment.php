<?php

namespace moki74\LaravelBtc\Commands;

use moki74\LaravelBtc\Bitcoind;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use moki74\LaravelBtc\Events\ConfirmedPaymentEvent;
use moki74\LaravelBtc\Events\UnconfirmedPaymentEvent;
use moki74\LaravelBtc\Events\UnknownTransactionEvent;
use moki74\LaravelBtc\Models\Payment;
use moki74\LaravelBtc\Models\UnknownTransaction;

class CheckPayment extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bitcoin:checkpayment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for bitcoin payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Bitcoind $bitcoind)
    {
        // $bitcoind = resolve("LaravelBtcClient");
        $this->checkPayment($bitcoind);
    }

    private function checkPayment($bitcoind)
    {
        // get transaction from bitcoind
        $transactions = $bitcoind->listtransactions('*', 50);
        if (!is_array($transactions)) {
            $transactions = $transactions->get();
        }
        $transactions = array_reverse($transactions);
        $transactions = array_filter($transactions, function ($v) {
            return $v['category'] == 'receive';
        });
        // reindex array - only transactions which receive bitcoins
        $transactions = array_values($transactions);

        // Prepayments without transaction - not paid yet
        $prepayments_no_tx = Payment::unpaid()->get();
        foreach ($prepayments_no_tx as $prepayment_no_tx) {
            // check if there are multiple payments to same address
            $keys = array_keys(array_column($transactions, 'address'), $prepayment_no_tx['address']);
            // only way to pair blockchain transaction with our db is by wallet address and amount
            $pair_found = false;
            foreach ($keys as $key) {
                if ($transactions[$key]['amount'] == $prepayment_no_tx->amount) {
                    $prepayment_no_tx->txid = $transactions[$key]['txid'];
                    $prepayment_no_tx->amount_received = $transactions[$key]['amount'];
                    $prepayment_no_tx->save();
                    event(new UnconfirmedPaymentEvent($prepayment_no_tx));
                    $pair_found = true;
                }
            }
            // wrong amount is paid - we dontß know for what order is that payment and this is unknown transaction
            if (!$pair_found) {
                foreach ($keys as $key) {
                    $unknownTx = UnknownTransaction::find($transactions[$key]['txid']);
                    if (!$unknownTx) {
                        $unknownTx = new UnknownTransaction;
                        $unknownTx->address =  $transactions[$key]['address'];
                        $unknownTx->amount_received =  $transactions[$key]['amount'];
                        $unknownTx->txid = $transactions[$key]['txid'];
                        event(new UnknownTransactionEvent($unknownTx));
                    }
                    $unknownTx->confirmations = $transactions[$key]['confirmations'];
                    $unknownTx->save();
                }
            }
        }

        //Check for Prepayments with transaction in blockchain (these are paid), but we need number of confirmations
        $prepayments = Payment::not_confirmed()->get();
        foreach ($prepayments as $prepayment) {
            $key = array_search($prepayment->txid, array_column($transactions, 'txid'));
            if ($key !== false) {
                $prepayment->confirmations = $transactions[$key]['confirmations'];
                // if we have min confirmations, payment is confirmed
                if ($prepayment->confirmations >= config('bitcoind.min-confirmations')) {
                    $prepayment->paid = 1;
                    event(new ConfirmedPaymentEvent($prepayment));
                }
                $prepayment->save();
            }
        }
    }
}
