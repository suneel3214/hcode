<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('place_bids', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('user_id')->unsigned()->nullable();
        //     $table->integer('product_id')->unsigned()->nullable();
        //     $table->string('your_bid_price')->nullable();
        //     $table->string('shipping_option')->nullable();
        //     $table->string('payment_methode')->nullable();
        //     $table->string('reminder_email')->nullable();
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
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
        Schema::dropIfExists('place_bids');
    }
}
