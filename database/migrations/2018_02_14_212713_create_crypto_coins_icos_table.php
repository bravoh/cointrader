<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoCoinsIcosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_coins_icos', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name', 150);
            $table->char('alias', 150);
            $table->tinyInteger('status')->default(0);
            $table->mediumText('image');
            $table->mediumText('website');
            $table->mediumText('icowatchlist_url');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->char('timezone', 10);
            $table->mediumText('description');
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
        Schema::dropIfExists('crypto_coins_icos');
    }
}
