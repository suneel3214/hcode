<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAssignTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('product_assign_templates', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('product_id')->unsigned()->nullable();
        //     $table->integer('template_id')->unsigned()->nullable();
        //     $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_assign_templates');
    }
}
