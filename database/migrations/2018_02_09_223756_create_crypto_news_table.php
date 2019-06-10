<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_news', function (Blueprint $table) {
            $table->increments('id');
            $table->char('author', 250)->nullable($value = true);
            $table->string('title', 500);
            $table->string('alias', 500);
            $table->longText('description')->nullable($value = true);
            $table->char('url', 250)->nullable($value = true);
            $table->char('urlToImage', 250)->nullable($value = true);
            $table->integer('publishedAt')->nullable($value = true);
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
        Schema::dropIfExists('crypto_news');
    }
}
