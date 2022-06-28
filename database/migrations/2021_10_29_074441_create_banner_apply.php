<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerApply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_apply', function (Blueprint $table) {
            $table->id();
            $table->string('heading',500);
            $table->string('highlight_text',50); 
            $table->string('link',50); 
            $table->integer('seller_id'); 
            $table->date('start_date'); 
            $table->date('end_date'); 
            $table->string('banner_location'); 
            $table->text('description'); 
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
        Schema::dropIfExists('banner_apply');
    }
}
