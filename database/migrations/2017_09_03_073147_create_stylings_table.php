<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStylingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stylings', function (Blueprint $table) {
            $table->increments('s_id');
            $table->integer('o_id');
            $table->integer('c_id');
            $table->string('fabric_id');
            $table->string('fabric_num');
            $table->string('lining_id');
            $table->string('lining_num');
            $table->string('fitting_id');
            $table->string('fitting');
            $table->string('fitting_img');
            $table->string('jacket_style_id');
            $table->string('jacket_style');
            $table->string('jacket_style_img');
            $table->string('front_panel_roundness_id');
            $table->string('front_panel_roundness');
            $table->string('front_panel_roundness_img');
            $table->string('jacket_length_id');
            $table->string('jacket_length');
            $table->string('jacket_length_img');
            $table->string('lapel_style_id');
            $table->string('lapel_style');
            $table->string('lapel_img');
            $table->string('lapel_curvature_id');
            $table->string('lapel_curvature');
            $table->string('lapel_curvature_img');
            $table->string('lapel_pick_stitch_id');
            $table->string('lapel_pick_stitch');
            $table->string('lapel_pick_stich_img');
            $table->string('shoulder_construction_id');
            $table->string('shoulder_construction');
            $table->string('shoulder_construction_img');
            $table->string('vent_style_id');
            $table->string('vent_style');
            $table->string('vent_style_img');
            $table->string('breast_pocket_id');
            $table->string('breast_pocket');
            $table->string('breast_pocket_img');
            $table->string('side_pocket_id');
            $table->string('side_pocket');
            $table->string('side_pocket_img');
            $table->string('ticket_pocket_id');
            $table->string('ticket_pocket');
            $table->string('ticket_pocket_img');
            $table->string('cuff_button_id');
            $table->string('cuff_button');
            $table->string('cuff_button_img');
            $table->string('functional_cuff_id');
            $table->string('functional_cuff');
            $table->string('functional_cuff_img');
            $table->string('trouser_pleat_id');
            $table->string('trouser_pleat');
            $table->string('trouser_pleat_img');
            $table->string('trouser_back_pocket_id');
            $table->string('trouser_back_pocket');
            $table->string('trouser_back_pocket_img');
            $table->string('trouser_cuff_id');
            $table->string('trouser_cuff');
            $table->string('trouser_cuff_img');
            $table->string('trouser_loop_tab_id');
            $table->string('trouser_loop_tab');
            $table->string('trouser_loop_tab_img');
            $table->string('waist_coat_type_id');
            $table->string('waist_coat_type');
            $table->string('waist_coat_type_img');
            $table->string('waist_coat_pocket_type_id');
            $table->string('waist_coat_pocket_type');
            $table->string('waist_coat_pocket_type_img');
            $table->string('back_id');
            $table->string('back');
            $table->string('back_img');
            $table->string('buttons_id');
            $table->string('buttons');
            $table->string('buttons_img');
            $table->string('lapel_eyelet_color_id');
            $table->string('lapel_eyelet_color');
            $table->string('lapel_eyelet_color_img');
            $table->string('cuff_eyelet_color_id');
            $table->string('cuff_eyelet_color');
            $table->string('cuff_eyelet_color_img');
            $table->string('piping_color_id');
            $table->string('piping_color');
            $table->string('piping_color_img');
            $table->string('melton_undercoller_num_id');
            $table->string('melton_undercoller_num');
            $table->string('melton_undercoller_num_img');
            $table->string('shoulder_pads_id');
            $table->string('shoulder_pads');
            $table->string('shoulder_pads_img');
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
        Schema::dropIfExists('stylings');
    }
}
