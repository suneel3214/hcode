<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cart_id')->unsigned();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('quantity')->nullable();
            $table->double('unit_price',10,2)->nullable();
            $table->double('total_price',10,2)->nullable();
            $table->double('tax_percentage',10,2)->nullable();
            $table->double('discount_percentage',10,2)->nullable();
            $table->double('discount_amount',10,2)->nullable();
            $table->double('tax_amount',10,2)->nullable();
            $table->double('amount',10,2)->nullable();
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('pro_id ')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('cart_item');
    }
}
