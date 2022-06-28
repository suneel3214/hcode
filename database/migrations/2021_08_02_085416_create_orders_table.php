<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

         Schema::create('shiping_address', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('street')->nullable();
            $table->string('type')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('invoice_number')->nullable();
            $table->integer('marchent_id')->unsigned()->nullable();
            $table->double('total_price',10,2)->nullable();
            $table->double('discounted_price',10,2)->nullable();
            $table->double('tax_price',10,2)->nullable();
            $table->double('amount',10,2)->nullable();
            $table->double('shiping_charges',10,2)->nullable();
            $table->integer('total_item')->nullable();
            $table->integer('item_qty')->nullable();
            $table->bigInteger('address_id')->unsigned()->nullable();
            $table->string('type_of_shiping')->nullable();
            $table->foreign('address_id')->references('id')->on('shiping_address')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('marchent_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('order_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned()->nullable();
           $table->integer('product_id')->unsigned()->nullable();
            $table->integer('quantity')->nullable();
            $table->double('unit_price',10,2)->nullable();
            $table->double('total_price',10,2)->nullable();
            $table->double('tax_percentage',10,2)->nullable();
            $table->double('discount_percentage',10,2)->nullable();
            $table->double('discount_amount',10,2)->nullable();
            $table->double('tax_amount',10,2)->nullable();
            $table->double('amount',10,2)->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('shiping_address');
        Schema::dropIfExists('order_item');
    }
}
