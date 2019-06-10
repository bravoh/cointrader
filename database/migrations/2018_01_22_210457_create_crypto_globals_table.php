<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_globals', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('total_market_cap_usd');
            $table->bigInteger('total_24h_volume_usd');
            $table->float('bitcoin_percentage_of_market_cap', 4, 2);
            $table->integer('active_currencies');
            $table->integer('active_assets');
            $table->integer('active_markets');
            $table->integer('last_updated');
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
        Schema::dropIfExists('crypto_globals');
    }
}
