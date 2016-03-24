<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocatariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locatarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razao', 255)->nullable();
            $table->string('fantasia', 255)->nullable();
            $table->string('documento', 255)->nullable();
            $table->string('inscricao', 255)->nullable();
            $table->string('fone', 255)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('cep', 255)->nullable();
            $table->string('responsavel', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('site', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->text('cidade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('locatarios');
    }
}
