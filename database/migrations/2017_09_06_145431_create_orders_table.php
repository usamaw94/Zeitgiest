<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('o_id');
            $table->integer('c_id');
            $table->string('s_id');
            $table->string('o_date');
            $table->string('item_type');
            $table->string('o_status');
            $table->string('o_price');
            $table->string('o_fabric');
            $table->string('o_lining');
            $table->string('delivery_date');
            $table->string('order_type');
            $table->string('base_pattern');
            $table->string('base_size');
            $table->string('photo_1');
            $table->string('photo_2');
            $table->string('photo_3');
            $table->string('photo_4');
            $table->string('photo_5');
            $table->string('photo_6');
            $table->string('photo_7');
            $table->string('photo_8');
            $table->string('photo_9');
            $table->string('photo_10');
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
        Schema::dropIfExists('orders');
    }
}
