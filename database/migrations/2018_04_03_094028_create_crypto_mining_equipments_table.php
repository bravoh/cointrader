<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoMiningEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_mining_equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->char('company', 150)->nullablle(true);
            $table->string('logo', 500)->nullablle(true);
            $table->char('name');
            $table->string('alias', 500);
            $table->string('affiliate', 1000)->nullablle(true);;
            $table->char('algorithm')->nullablle(true);;
            $table->char('hashes_per_second')->nullablle(true);;
            $table->char('cost')->nullablle(true);;
            $table->char('currency')->nullablle(true);;
            $table->char('type')->nullablle(true);;
            $table->char('power_consumption')->nullablle(true);;
            $table->char('currencies_available')->nullablle(true);;
            $table->boolean('recommended')->nullablle(true)->default(1);
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
        Schema::dropIfExists('crypto_mining_equipments');
    }
}
