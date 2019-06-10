<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string("ref_no");
            $table->double("amount");
            $table->string("payment_mode");
            $table->string("email_address")->nullable();
            $table->string("country_code")->nullable();
            $table->string("name")->nullable();
            $table->text("payload")->nullable();
            $table->unsignedInteger("exchange_id");
            $table->timestamps();

            $table->foreign('exchange_id')
                ->references('id')
                ->on('exchanges')
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
        Schema::dropIfExists('payments');
    }
}
