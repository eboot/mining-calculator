<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('coins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ticker');
            $table->integer('block_reward');
            $table->integer('block_time');
            $table->bigInteger('current_hash_rate');
            $table->decimal('current_diff');
            $table->timestamps();
        });

        Schema::create('hash_rate_ticks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coin_id');
            $table->decimal('difficulty', 15, 9);
            $table->bigInteger('hashrate');
            $table->integer('tick_time');
        });

        Schema::create('exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('coin_exchange', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coin_id');
            $table->integer('exchange_id');
            $table->string('ticker_string');
            $table->decimal('last_price', 15,8);
            $table->decimal('variation_24hr');
            $table->decimal('volume', 15, 8);
            $table->integer('updated_at');
        });

        Schema::create('ticks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coin_id');
            $table->integer('exchange_id');
            $table->decimal('last_price', 15,8);
            $table->integer('tick_time');
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
