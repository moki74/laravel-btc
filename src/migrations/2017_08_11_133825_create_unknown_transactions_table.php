<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnknownTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unknown_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->double('amount_received')->default(0);
            $table->double('confirmations')->default(0);
            $table->string('txid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unknown_transactions');
    }
}
