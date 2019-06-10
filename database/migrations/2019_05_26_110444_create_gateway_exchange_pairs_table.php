<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewayExchangePairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway_exchange_pairs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("send_id");
            $table->unsignedInteger("receive_id");
            $table->float("rate");
            $table->float("reserve");
            $table->timestamps();

            $table->foreign('send_id')
                ->references('id')
                ->on('gateways')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('receive_id')
                ->references('id')
                ->on('gateways')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gateway_exchange_pairs');
    }
}
