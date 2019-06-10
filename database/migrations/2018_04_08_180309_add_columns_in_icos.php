<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInIcos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crypto_coins_icos', function ($table) {
            $table->tinyInteger('featured')->nullable()->default('0')->after('status');
            $table->mediumText('affiliate')->nullable()->default('')->after('icowatchlist_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crypto_coins_icos', function ($table) {
             // $table->dropColumn('featured');
             //  $table->dropColumn('affiliate');
        });
    }
}
