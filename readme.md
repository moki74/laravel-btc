# laravel-btc
Package for receive payments via BTC
## Installation
```
composer require moki74/laravel-btc
```
After installation publish package with artisan command :
```
php artisan vendor:publish
```
and choose by tag **bitcoin**.
## Usage
There are two main objects in package :

**1. moki74\LaravelBtc\Bitcoind** - this is a wrapper for RPC commands to bitcoin server.
You can make this object via Laravel **app** helper function like this:
```
$btc = app("bitcoind");
// or
$btc = app("moki74\LaravelBtc\Bitcoind");
```

and then call RPC method on object :

```
$bitcoinaddress = $btc->getnewaddress();
// You can call any RPC method
// see this url : https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_calls_list
```
You can  use just this object for simpler projects  ...

**2. moki74\LaravelBtc\Models\Payment** - this object is model for payment with Bitcoin , creates for you new Bitcoin address, amount, track if customer made payment, store it to database ...

Again, use **app** helper function like this:
```
$payment = app("moki74\LaravelBtc\Models\Payment");
//or
$payment = app("bitcoinPayment");

```

This object contains following properties:

**user_id** - id of user who made order

**order_id** - order id (not mandatory)

**address** - bitcoin address (this is automatically generated for you when you call $payment = app("bitcoinPayment"))

**paid** - this is indicator if user is made payment and number of confirmations on block chain is ok (there is configuration parameter for minimum number of confirmations, more about that later ..)

**amount** - price that user need to pay

**amount_received** - amount of bitcoin that is actually received (some user can make mistake and send bitcoins with fee deducted from amount send from their wallet, than you wont get expected amount)

**txid** - transaction id in block chain for this payment (this is populated in database when user actually make payment)

**confirmations** - number of confirmations for payment.



## Contributing
1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D
## History
TODO: Write history
## Credits
TODO: Write credits
## License
TODO: Write License tst