<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chatrooms', function (Blueprint $table) {
            $table->id();
            $table->integer('initiator_id');
            $table->timestamps();
        });

        Schema::create('chatroom_users', function (Blueprint $table) {
            $table->id();
            $table->integer('chatroom_id');
            $table->integer('UserId');
            $table->timestamps();
        });

        Schema::create('chatroom_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('chatroomId');
            $table->integer('senderId');
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('unread_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('message_id');
            $table->integer('chatroom_id');
            $table->dateTime('read_at');
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
        Schema::dropIfExists('chat');
    }
}
