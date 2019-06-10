<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("gateway_exchange_pair_id");
            $table->string("bit_currency_from")->nullable();
            $table->string("bit_currency_to")->nullable();
            $table->double("exchange_rate")->nullable();
            $table->double("send_amount");
            $table->double("receive_amount");
            $table->string("email_address");
            $table->string("crypto_address");
            $table->boolean("paid")->default(false);
            $table->timestamps();

            $table->foreign('gateway_exchange_pair_id')
                ->references('id')
                ->on('gateway_exchange_pairs')
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
        Schema::dropIfExists('exchanges');
    }
}
