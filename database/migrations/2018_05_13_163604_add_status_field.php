<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crypto_exchanges', function($table) {
            $table->tinyInteger('status')->default(1);
        });

        Schema::table('crypto_markets', function($table) {
            $table->tinyInteger('status')->default(1);
        });

        Schema::table('crypto_news', function($table) {
            $table->tinyInteger('status')->default(1);
        });

        Schema::table('crypto_coins_full_details', function($table) {
            $table->tinyInteger('status')->default(1);
        });

        Schema::table('crypto_mining_equipments', function($table) {
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
