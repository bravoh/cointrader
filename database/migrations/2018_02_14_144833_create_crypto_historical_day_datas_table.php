<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoHistoricalDayDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_historical_day_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->char('coin', 15);
            $table->Integer('time');
            $table->double('open', 14, 6);
            $table->double('close', 14, 6);
            $table->double('high', 14, 6);
            $table->double('low', 14, 6);
            $table->double('volume_from', 25, 6);
            $table->double('volume_to', 25, 6);
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
        Schema::dropIfExists('crypto_historical_day_datas');
    }
}
