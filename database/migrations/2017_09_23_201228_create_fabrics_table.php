<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabrics', function (Blueprint $table) {
            $table->increments('itm_id');
            $table->string('itm_num');
            $table->string('itm_img');
            $table->string('itm_img_src');
            $table->double('stock');
            $table->string('three_piece_suit');
            $table->string('two_piece_suit');
            $table->string('jacket');
            $table->string('waist_coat');
            $table->string('pant');
            $table->string('shirt');
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
        Schema::dropIfExists('fabrics');
    }
}
