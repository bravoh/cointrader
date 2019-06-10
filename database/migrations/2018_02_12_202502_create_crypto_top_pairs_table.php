<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoTopPairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_top_pairs', function (Blueprint $table) {
            $table->increments('id');
            $table->char('symbol', 15);
            $table->char('pair', 15)->nullable($value = true);
            $table->double('volume24h_from', 25, 2)->nullable($value = true);
            $table->double('volume24h_to', 25, 2)->nullable($value = true);
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
        Schema::dropIfExists('crypto_top_pairs');
    }
}
