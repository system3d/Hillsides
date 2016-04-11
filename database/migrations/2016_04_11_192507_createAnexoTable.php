<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnexoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descricao')->nullable();

            $table->integer('tarefa_id')->unsigned();
            $table->foreign('tarefa_id')->references('id')->on('tarefas')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('anexos', function (Blueprint $table) {
            $table->dropForeign('anexos_tarefa_id_foreign');
            $table->dropForeign('anexos_locatario_id_foreign');
        });
        Schema::drop('anexos');
    }
}
