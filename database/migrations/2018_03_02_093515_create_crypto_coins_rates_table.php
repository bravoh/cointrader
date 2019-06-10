<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoCoinsRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_coins_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->char('coin' , 10);
            $table->char('f_currency', 5);
            $table->double('price', 14, 6)->default(0);
            $table->float('change_hour')->default(0);
            $table->float('change_day')->default(0);
            $table->unique(['coin', 'f_currency']);
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
        Schema::dropIfExists('crypto_coins_rates');
    }
}
