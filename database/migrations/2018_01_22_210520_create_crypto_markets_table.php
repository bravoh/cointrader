<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_markets', function (Blueprint $table) {
            $table->increments('sr_no');
            $table->char('id', 100);
            $table->char('name', 100);
            $table->char('symbol', 15)->nullable($value = true);
            $table->char('image', 15)->nullable($value = true);
            $table->integer('rank')->default(0)->nullable($value = true);
            $table->float('price_usd', 14, 6)->default(0)->nullable($value = true);
            $table->double('price_btc', 14, 9)->default(0)->nullable($value = true);
            $table->bigInteger('volume_usd_day')->nullable($value = true);
            $table->bigInteger('market_cap_usd')->nullable($value = true);
            $table->bigInteger('available_supply')->nullable($value = true);
            $table->bigInteger('total_supply')->nullable($value = true);
            $table->bigInteger('max_supply')->nullable($value = true);
            $table->float('percent_change_hour')->default(0)->nullable($value = true);
            $table->float('percent_change_day')->default(0)->nullable($value = true);
            $table->float('percent_change_week')->default(0)->nullable($value = true);
            $table->integer('last_updated')->default(0)->nullable($value = true);
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
        Schema::dropIfExists('crypto_markets');
    }
}
