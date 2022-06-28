<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvinceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('province', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('region', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('province')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('city', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('region')->onDelete('cascade');
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
        Schema::dropIfExists('province');
    }
}
