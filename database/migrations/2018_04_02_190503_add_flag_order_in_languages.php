<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlagOrderInLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('available_languages', function ($table) {
            $table->char('flag', 15)->nullable()->default('')->after('status');
            $table->char('order', 15)->nullable()->default(1)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            // $table->dropColumn('flag');
            // $table->dropColumn('order');
        });  
    }
}
