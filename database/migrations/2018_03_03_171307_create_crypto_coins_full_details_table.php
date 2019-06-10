<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoCoinsFullDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_coins_full_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 500)->nullablle(true);
            $table->string('alias', 500);
            $table->mediumText('seo_description')->nullablle(true);
            $table->char('full_name', 150)->nullablle(true);
            $table->char('symbol', 15);
            $table->longText('description')->nullablle(true);
            $table->longText('features')->nullablle(true);
            $table->longText('technology')->nullablle(true);
            $table->char('algorithm', 25)->nullablle(true);
            $table->char('proof_type', 5)->nullablle(true);
            $table->integer('start_date')->nullablle(true);
            $table->char('twitter', 50)->nullablle(true);
            $table->char('reddit', 100)->nullablle(true);
            $table->char('facebook', 100)->nullablle(true);
            $table->char('website_url', 250)->nullablle(true);
            $table->bigInteger('block_number')->nullablle(true);
            $table->integer('block_time')->nullablle(true);
            $table->bigInteger('total_coins_mined')->nullablle(true);
            $table->bigInteger('previous_total_coins_mined')->nullablle(true);
            $table->integer('block_reward')->default(0)->nullablle(true);
            $table->char('net_hases_per_second', 150)->default(0)->nullablle(true);
            $table->char('ico_status', 50)->nullablle(true);
            $table->longText('ico_description')->nullablle(true);
            $table->char('ico_token_supply', 150)->default(0)->nullablle(true);
            $table->integer('ico_start_date')->default(0)->nullablle(true);
            $table->integer('ico_end_date')->default(0)->nullablle(true);
            $table->char('ico_fund_raised_btc', 150)->default(0)->nullablle(true);
            $table->char('ico_fund_raised_usd', 150)->default(0)->nullablle(true);
            $table->char('ico_start_price', 150)->default(0)->nullablle(true);
            $table->char('ico_security_audit_company', 150)->nullablle(true);
            $table->char('ico_legal_form', 150)->nullablle(true);
            $table->char('ico_jurisdiction', 150)->nullablle(true);
            $table->char('ico_legal_advisers', 150)->nullablle(true);
            $table->char('ico_blog', 250)->nullablle(true);
            $table->char('ico_white_paper_link', 250)->nullablle(true);
            $table->unique('symbol');
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
        Schema::dropIfExists('crypto_coins_full_details');
    }
}
