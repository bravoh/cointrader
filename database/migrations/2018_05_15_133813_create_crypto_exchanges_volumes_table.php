<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoExchangesVolumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_exchanges_volumes', function (Blueprint $table) {
            $table->increments('id');
            $table->char('symbol', 7);
            $table->char('to_symbol', 7);
            $table->char('exchange', 25);
            $table->char('pair', 15);
            $table->double('price', 25, 8)->default(0);
            $table->double('volume_day_from', 25, 8);
            $table->double('volume_day_to', 25, 8);
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
        Schema::dropIfExists('crypto_exchanges_volumes');
    }
}
