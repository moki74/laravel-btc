<?php

namespace moki74\BtcPayment;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Denpa\Bitcoin\Client as BitcoinClient;

class BitcoinPaymentServiceProvider extends ServiceProvider
{
    // protected $listen = [
    //     'moki74\BtcPayment\Events\UnknownTransactionEvent' => [
    //         '\moki74\BtcPayment\Listeners\UnknownTransactionNotification'
    //     ],

    // ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->publishes([
                     __DIR__.'/Listeners' => base_path('app/Listeners'),
                 ] , 'bitcoin');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\CheckPayment::class,
            ]);
        }

        $this->registerEloquentFactoriesFrom(__DIR__.'/factories');

        $this->app->bind('BtcPayment', function ($app) {
            $payment = new \moki74\BtcPayment\Models\Payment;
            $payment->address = resolve(BitcoinClient::class)->getnewaddress();
            return $payment;
        });
    }

    /**
     *
     * @param  string $path [path to factory]
     * @return Illuminate\Database\Eloquent\Factory
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }
}
