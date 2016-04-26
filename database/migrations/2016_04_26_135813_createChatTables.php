<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message')->nullable();
            $table->integer('status')->nullable();
            $table->integer('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('receiver_id')->unsigned();
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('online', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');
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
        Schema::table('messages', function (Blueprint $table) {
           $table->dropForeign('messages_sender_id_foreign');
           $table->dropForeign('messages_receiver_id_foreign');
           $table->dropForeign('messages_locatario_id_foreign');
        });
        Schema::drop('messages');
        Schema::table('online', function (Blueprint $table) {
           $table->dropForeign('online_user_id_foreign');
           $table->dropForeign('online_locatario_id_foreign');
        });
        Schema::drop('online');
    }
}
