<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name')->nullable();
            $table->string('image_link', 500);
            $table->string('text', 500)->nullable();
            $table->string('page_link', 500)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->char('lang')->default('en');
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
        Schema::dropIfExists('dashboard_sliders');
    }
}
