<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnreadmessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unreadmessage', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chatroomId')->unsigned();
            $table->integer('userId')->unsigned();
            $table->bigInteger('message_id')->unsigned();
            $table->date('read_at');
            $table->foreign('message_id')->references('id')->on('chatroom_messages')->onDelete('cascade');
            $table->foreign('chatroomId')->references('id')->on('chatrooms')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('unreadmessage');
    }
}
