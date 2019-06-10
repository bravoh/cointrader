<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->char('exchange_id', 50);
            $table->char('name', 50);
            $table->char('website', 150)->nullable($value = true);
            $table->char('affiliate', 50)->nullable($value = true);
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
        Schema::dropIfExists('crypto_exchanges');
    }
}
