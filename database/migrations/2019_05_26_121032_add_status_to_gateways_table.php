<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gateways', function (Blueprint $table) {
            $table->boolean("active")
                ->default(true)
                ->after("icon");
        });

        Schema::table('gateway_exchange_pairs', function (Blueprint $table) {
            $table->boolean("active")
                ->after("reserve")
                ->default(true);

            $table->float("reserve")
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gateways', function (Blueprint $table) {
            $table->dropColumn(["active"]);
        });

        Schema::table('gateway_exchange_pairs', function (Blueprint $table) {
            $table->dropColumn(["active"]);
        });
    }
}
