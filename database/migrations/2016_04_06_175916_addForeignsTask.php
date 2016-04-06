<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->integer('disciplina_id')->nullable()->unsigned();
            $table->foreign('disciplina_id')->references('id')->on('disciplinas')->onDelete('cascade');
            $table->integer('etapa_id')->nullable()->unsigned();
            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropForeign('tarefas_disciplinas_id_foreign');
            $table->dropForeign('tarefas_etapa_id_foreign');
            $table->dropColumn('etapa_id')->nullable();
            $table->dropColumn('disciplina_id')->nullable();
        });
    }
}
