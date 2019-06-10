<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToTopPairs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crypto_top_pairs', function(Blueprint $table)
        {
            $table->unique(['symbol', 'pair']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crypto_top_pairs', function (Blueprint $table)
        {
             $table->dropUnique(['symbol', 'pair']);
        });
    }
}
