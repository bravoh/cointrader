<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoTwitterFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_twitter_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('twitter_unique_id');
            $table->string('tweet', 300);
            $table->char('author', 75);
            $table->integer('tweeted_at');
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
        Schema::dropIfExists('crypto_twitter_feeds');
    }
}
