<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('templates', function (Blueprint $table) {
            // $table->id();
            // $table->integer('user_id')->unsigned()->nullable();
            // $table->integer('name')->nullable();
            // $table->integer('sequence_no')->nullable();
            // $table->integer('slug')->nullable();
            // $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            // $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('templates');
    }
}
