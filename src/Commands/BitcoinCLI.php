<?php

namespace moki74\BtcPayment\Commands;

use Illuminate\Console\Command;
use Denpa\Bitcoin\Client as BitcoinClient;
use moki74\BtcPayment\Models\Payment;
use moki74\BtcPayment\Models\UnknownTransaction;
use moki74\BtcPayment\BitcoinPaymentServiceProvider;

class BitcoinCLI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bitcoin {rpc} {option?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call bitcoin jrpc';

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
    public function handle(BitcoinClient $bitcoind)
    {
        $pay= resolve('BtcPayment');
        $this->bitcoin($bitcoind);
    }

    private function bitcoin($bitcoind)
    {
        // get transaction from bitcoind
        //
        //dd($this->argument('option'));
        $rpc = $this->argument('rpc');
        $option = $this->argument('option') ?? '';
        $options= explode(",", $option);
        // we need integer values as real integer for call
        foreach($options as $key => $val){
            if(is_numeric($val)){
                $options[$key] = (int) $val;
            }
        }
//            dd($options);
        //$rpc .= '('.$option.')';
        //dd($arguments = $this->argument());
        dd(call_user_func_array(array($bitcoind, $rpc), $options));
        echo "\n";

    }


}
