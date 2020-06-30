<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->increments('m_id');
            $table->integer('o_id');
            $table->integer('c_id');
            $table->string('stance_id');
            $table->string('stance');
            $table->string('stance_img');
            $table->string('shoulder_id');
            $table->string('shoulder');
            $table->string('shoulder_img');
            $table->string('chest_id');
            $table->string('chest');
            $table->string('chest_img');
            $table->string('stomach_id');
            $table->string('stomach');
            $table->string('stomach_img');
            $table->string('hip_id');
            $table->string('hip');
            $table->string('hip_img');
            $table->double('neck');
            $table->double('full_chest');
            $table->double('shoulder_width');
            $table->double('right_sleeve');
            $table->double('left_sleeve');
            $table->double('bicep');
            $table->double('wrist');
            $table->double('waist_stomach');
            $table->double('hip_m');
            $table->double('front_jacket_length');
            $table->double('front_chest_width');
            $table->double('back_width');
            $table->double('half_shoulder_width_left');
            $table->double('half_shoulder_width_right');
            $table->double('full_back_length');
            $table->double('half_back_length');
            $table->double('trouser_waist');
            $table->double('trouser_outseam');
            $table->double('trouser_inseam');
            $table->double('crotch');
            $table->double('thigh');
            $table->double('knee');
            $table->double('right_full_sleeve');
            $table->double('left_full_sleeve');
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
        Schema::dropIfExists('measurements');
    }
}
