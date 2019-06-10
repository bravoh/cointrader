<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCryptoMarketsTableForImagesChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crypto_markets', function($table){
            $table->renameColumn('id', 'unique_name');
            $table->renameColumn('sr_no', 'id');
            $table->string('image', 250)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crypto_markets', function($table){
            $table->renameColumn('id', 'sr_no');
            $table->renameColumn('unique_name', 'id');
            $table->string('image', 15)->change();
        });
    }
}
