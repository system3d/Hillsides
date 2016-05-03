<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model')->nullable();
            $table->string('name')->nullable();
            $table->string('param')->nullable();
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
         Schema::table('settings', function (Blueprint $table) {
           $table->dropForeign('settings_user_id_foreign');
           $table->dropForeign('settings_locatario_id_foreign');
        });
        Schema::drop('settings');
    }
}
