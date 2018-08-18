<?php

namespace moki74\LaravelBtc;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use moki74\LaravelBtc\Bitcoind;

class BitcoinPaymentServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //publish config file and merge config
        $path = realpath(__DIR__.'/../config/bitcoind.php');
        $this->publishes([$path => config_path('bitcoind.php')], 'bitcoin');
        $this->mergeConfigFrom($path, 'bitcoind');

        //publish listeners for payment events
        $this->publishes([
                     __DIR__.'/Listeners' => base_path('app/Listeners'),
                 ], 'bitcoin');
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


        $this->registerBitcoind();

        $this->registerBitcoinPayment();
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

    /**
     * @return \moki74\LaravelBtc\Bitcoind object
     */
    protected function registerBitcoind()
    {
        $this->app->singleton('bitcoind', function ($app) {
            return $this->resolveBtc($app);
        });

        $this->app->singleton('moki74\LaravelBtc\Bitcoind', function ($app) {
            return $this->resolveBtc($app);
        });
    }

    /**
     *
     * @param App $app
     * @return \moki74\LaravelBtc\Bitcoind object
     */
    private function resolveBtc($app)
    {
        return new \moki74\LaravelBtc\Bitcoind(
            $app['config']->get('bitcoind.user'),
            $app['config']->get('bitcoind.password'),
            $app['config']->get('bitcoind.host', 'localhost'),
            $app['config']->get('bitcoind.port', 18332)
        );
    }

    /**
    * @return \moki74\LaravelBtc\Models\Payment object
    */
    protected function registerBitcoinPayment()
    {
        $this->app->bind('bitcoinPayment', function ($app) {
            return $this->resolveBtcPayment($app);
        });

        $this->app->bind('moki74\LaravelBtc\Models\Payment', function ($app) {
            return $this->resolveBtcPayment($app);
        });
    }

    /**
     *
     * @param App $app
     * @return \moki74\LaravelBtc\Models\Payment object
     */
    private function resolveBtcPayment($app)
    {
        $payment = new \moki74\LaravelBtc\Models\Payment;
        $payment->address = resolve("bitcoind")->getnewaddress();
        return $payment;
    }
}
