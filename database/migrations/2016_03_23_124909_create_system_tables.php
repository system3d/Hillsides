<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
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
            $table->mediumText('obs')->nullable();
            $table->text('cidade')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('tiposcontatos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descricao')->nullable();

            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('contatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razao', 255)->nullable();
            $table->string('fantasia', 255)->nullable();

            $table->integer('tipocontato_id')->nullable()->unsigned();
            $table->foreign('tipocontato_id')->references('id')->on('tiposcontatos')->onDelete('set null');

            $table->string('documento', 255)->nullable();
            $table->string('inscricao', 255)->nullable();
            $table->string('fone', 255)->nullable();
            $table->text('cidade')->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('cep', 255)->nullable();
            $table->string('responsavel', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('site', 255)->nullable();
            $table->text('crea')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('equipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->mediumText('obs')->nullable();
            $table->integer('responsavel_id')->unsigned();
            $table->foreign('responsavel_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('status_projeto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('status_projeto_default', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('tipos_projeto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('projetos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->mediumText('obs')->nullable();
            $table->integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->integer('tipo_id')->unsigned();
            $table->foreign('tipo_id')->references('id')->on('tipos_projeto')->onDelete('cascade');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('status_projeto')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('sprints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->mediumText('obs')->nullable();
            $table->integer('projeto_id')->unsigned();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('etapas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->mediumText('obs')->nullable();
            $table->integer('projeto_id')->unsigned();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('disciplinas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->mediumText('obs')->nullable();
            $table->integer('projeto_id')->unsigned();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('historias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->mediumText('obs')->nullable();
            $table->integer('sprint_id')->unsigned();
            $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('estagios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->integer('ordem')->unsigned();
            $table->integer('projeto_id')->unsigned();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('estagios_default', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->integer('ordem')->unsigned();
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('tipos_tarefa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->string('icone', 255)->nullable();
            $table->integer('projeto_id')->unsigned();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('tipos_tarefa_default', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->string('icone', 255)->nullable();
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('status_tarefa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->integer('projeto_id')->unsigned();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('status_tarefa_default', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('tarefas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->mediumText('obs')->nullable();
            $table->integer('peso')->unsigned();
            $table->integer('sprint_id')->unsigned();
            $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
            $table->integer('historia_id')->unsigned();
            $table->foreign('historia_id')->references('id')->on('historias')->onDelete('cascade');
            $table->integer('assignee_id')->unsigned();
            $table->foreign('assignee_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('tipo_id')->unsigned();
            $table->foreign('tipo_id')->references('id')->on('tipos_tarefa')->onDelete('cascade');
            $table->integer('estagio_id')->unsigned();
            $table->foreign('estagio_id')->references('id')->on('estagios')->onDelete('cascade');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('status_tarefa')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('tipos_custo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 255)->nullable();
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('custos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('valor')->unsigned();
            $table->mediumText('obs')->nullable();
            $table->integer('tipo_id')->unsigned();
            $table->foreign('tipo_id')->references('id')->on('tipos_custo')->onDelete('cascade');
            $table->integer('tarefa_id')->unsigned();
            $table->foreign('tarefa_id')->references('id')->on('tarefas')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('cronogramas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('previsto')->nullable();
            $table->date('realizado')->nullable();
            $table->integer('tarefa_id')->unsigned();
            $table->foreign('tarefa_id')->references('id')->on('tarefas')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('projeto_contato', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('projeto_id')->unsigned();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->integer('contato_id')->unsigned();
            $table->foreign('contato_id')->references('id')->on('contatos')->onDelete('cascade');
        });

        Schema::create('projeto_equipe', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('projeto_id')->unsigned();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->integer('equipe_id')->unsigned();
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
        });

         Schema::create('user_equipe', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('equipe_id')->unsigned();
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_equipe', function (Blueprint $table) {
            $table->dropForeign('user_equipe_user_id_foreign');
            $table->dropForeign('user_equipe_equipe_id_foreign');
        });
        Schema::drop('user_equipe');
        Schema::table('projeto_equipe', function (Blueprint $table) {
            $table->dropForeign('projeto_equipe_projeto_id_foreign');
            $table->dropForeign('projeto_equipe_equipe_id_foreign');
        });
        Schema::drop('projeto_equipe');
        Schema::table('projeto_contato', function (Blueprint $table) {
            $table->dropForeign('projeto_contato_projeto_id_foreign');
            $table->dropForeign('projeto_contato_contato_id_foreign');
        });
        Schema::drop('projeto_contato');
        Schema::table('cronogramas', function (Blueprint $table) {
            $table->dropForeign('cronogramas_tarefa_id_foreign');
            $table->dropForeign('cronogramas_user_id_foreign');
            $table->dropForeign('cronogramas_locatario_id_foreign');
        });
        Schema::drop('cronogramas');
        Schema::table('custos', function (Blueprint $table) {
            $table->dropForeign('custos_tipo_id_foreign');
            $table->dropForeign('custos_tarefa_id_foreign');
            $table->dropForeign('custos_user_id_foreign');
            $table->dropForeign('custos_locatario_id_foreign');
        });
        Schema::drop('custos');
        Schema::table('tipos_custo', function (Blueprint $table) {
            $table->dropForeign('tipos_custo_locatario_id_foreign');
        });
        Schema::drop('tipos_custo');
        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropForeign('tarefas_sprint_id_foreign');
            $table->dropForeign('tarefas_historia_id_foreign');
            $table->dropForeign('tarefas_assignee_id_foreign');
            $table->dropForeign('tarefas_tipo_id_foreign');
            $table->dropForeign('tarefas_estagio_id_foreign');
            $table->dropForeign('tarefas_status_id_foreign');
            $table->dropForeign('tarefas_user_id_foreign');
            $table->dropForeign('tarefas_locatario_id_foreign');
        });
        Schema::drop('tarefas');
        Schema::table('status_tarefa_default', function (Blueprint $table) {
            $table->dropForeign('status_tarefa_default_locatario_id_foreign');
        });
        Schema::drop('status_tarefa_default');
        Schema::table('status_tarefa', function (Blueprint $table) {
            $table->dropForeign('status_tarefa_projeto_id_foreign');
            $table->dropForeign('status_tarefa_locatario_id_foreign');
        });
        Schema::drop('status_tarefa');
        Schema::table('tipos_tarefa_default', function (Blueprint $table) {
            $table->dropForeign('tipos_tarefa_default_locatario_id_foreign');
        });
        Schema::drop('tipos_tarefa_default');
        Schema::table('tipos_tarefa', function (Blueprint $table) {
            $table->dropForeign('tipos_tarefa_projeto_id_foreign');
            $table->dropForeign('tipos_tarefa_locatario_id_foreign');
        });
        Schema::drop('tipos_tarefa');
        Schema::table('estagios_default', function (Blueprint $table) {
            $table->dropForeign('estagios_default_locatario_id_foreign');
        });
        Schema::drop('estagios_default');
        Schema::table('estagios', function (Blueprint $table) {
            $table->dropForeign('estagios_projeto_id_foreign');
            $table->dropForeign('estagios_locatario_id_foreign');
        });
        Schema::drop('estagios');
        Schema::table('historias', function (Blueprint $table) {
            $table->dropForeign('historias_sprint_id_foreign');
            $table->dropForeign('historias_user_id_foreign');
            $table->dropForeign('historias_locatario_id_foreign');
        });
        Schema::drop('historias');
        Schema::table('disciplinas', function (Blueprint $table) {
            $table->dropForeign('disciplinas_projeto_id_foreign');
            $table->dropForeign('disciplinas_user_id_foreign');
            $table->dropForeign('disciplinas_locatario_id_foreign');
        });
        Schema::drop('disciplinas');
        Schema::table('etapas', function (Blueprint $table) {
            $table->dropForeign('etapas_projeto_id_foreign');
            $table->dropForeign('etapas_user_id_foreign');
            $table->dropForeign('etapas_locatario_id_foreign');
        });
        Schema::drop('etapas');
        Schema::table('sprints', function (Blueprint $table) {
            $table->dropForeign('sprints_projeto_id_foreign');
            $table->dropForeign('sprints_user_id_foreign');
            $table->dropForeign('sprints_locatario_id_foreign');
        });
        Schema::drop('sprints');
        Schema::table('projetos', function (Blueprint $table) {
            $table->dropForeign('projetos_tipo_id_foreign');
            $table->dropForeign('projetos_status_id_foreign');
            $table->dropForeign('projetos_user_id_foreign');
            $table->dropForeign('projetos_locatario_id_foreign');
        });
        Schema::drop('projetos');
        Schema::table('tipos_projeto', function (Blueprint $table) {
            $table->dropForeign('projetos_locatario_id_foreign');
        });
        Schema::drop('tipos_projeto');
        Schema::table('status_projeto', function (Blueprint $table) {
            $table->dropForeign('status_projeto_user_id_foreign');
            $table->dropForeign('status_projeto_locatario_id_foreign');
        });
        Schema::drop('status_projeto');
        Schema::table('status_projeto_default', function (Blueprint $table) {
            $table->dropForeign('status_projeto_default_locatario_id_foreign');
        });
        Schema::drop('status_projeto_default');
        Schema::table('equipes', function (Blueprint $table) {
            $table->dropForeign('equipes_user_id_foreign');
            $table->dropForeign('equipes_responsavel_id_foreign');
            $table->dropForeign('equipes_locatario_id_foreign');
        });
        Schema::drop('equipes');
        Schema::table('contatos', function (Blueprint $table) {
            $table->dropForeign('contatos_tipocontato_id_foreign');
            $table->dropForeign('contatos_user_id_foreign');
            $table->dropForeign('contatos_locatario_id_foreign');
        });
        Schema::drop('contatos');
        Schema::table('tiposcontatos', function (Blueprint $table) {
            $table->dropForeign('tiposcontatos_locatario_id_foreign');
        });
        Schema::drop('tiposcontatos');
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign('clientes_user_id_foreign');
            $table->dropForeign('clientes_locatario_id_foreign');
        });
        Schema::drop('clientes');
    }
}
