<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DefaultTableSeed extends Seeder{

    public function run(){

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('estagios_default')->truncate();
        DB::table('status_projeto_default')->truncate();
      	DB::table('status_tarefa_default')->truncate();
        DB::table('tipos_tarefa_default')->truncate();

        $estagio_model       		 =  App\Estagio_Default::class;
        $status_projeto_model        =  App\Status_Projeto_Default::class;
        $status_tarefa_model         =  App\Status_Tarefa_Default::class;
        $tipos_tarefa_model          =  App\Tipo_Tarefa_Default::class;


        $tarefa           		  = new $tipos_tarefa_model;
        $tarefa->descricao       = 'Bug';
        $tarefa->icone      	  = 'default.png';
        $tarefa->locatario_id    = 1;
        $tarefa->created_at	  = Carbon::now();
        $tarefa->updated_at	  = Carbon::now();
        $tarefa->save();

        $tarefa           		  = new $tipos_tarefa_model;
        $tarefa->descricao       = 'Nova';
        $tarefa->icone      	  = 'default.png';
        $tarefa->locatario_id    = 1;
        $tarefa->created_at	  = Carbon::now();
        $tarefa->updated_at	  = Carbon::now();
        $tarefa->save();

        $tarefa           		  = new $tipos_tarefa_model;
        $tarefa->descricao       = 'Melhoria';
        $tarefa->icone      	  = 'default.png';
        $tarefa->locatario_id    = 1;
        $tarefa->created_at	  = Carbon::now();
        $tarefa->updated_at	  = Carbon::now();
        $tarefa->save();

        $tarefa           		  = new $tipos_tarefa_model;
        $tarefa->descricao       = 'Sugestão';
        $tarefa->icone      	  = 'default.png';
        $tarefa->locatario_id    = 1;
        $tarefa->created_at	  = Carbon::now();
        $tarefa->updated_at	  = Carbon::now();
        $tarefa->save();

        $tarefa           		  = new $tipos_tarefa_model;
        $tarefa->descricao       = 'Lembrete';
        $tarefa->icone      	  = 'default.png';
        $tarefa->locatario_id    = 1;
        $tarefa->created_at	  = Carbon::now();
        $tarefa->updated_at	  = Carbon::now();
        $tarefa->save();

        $estagio           		  = new $estagio_model;
        $estagio->descricao       = 'Fazendo';
        $estagio->ordem      	  = 2;
        $estagio->locatario_id    = 1;
        $estagio->created_at	  = Carbon::now();
        $estagio->updated_at	  = Carbon::now();
        $estagio->save();

        $estagio           		  = new $estagio_model;
        $estagio->descricao       = 'Testando';
        $estagio->ordem      	  = 3;
        $estagio->locatario_id    = 1;
        $estagio->created_at	  = Carbon::now();
        $estagio->updated_at	  = Carbon::now();
        $estagio->save();

        $estagio           		  = new $estagio_model;
        $estagio->descricao       = 'Impedimentos';
        $estagio->ordem      	  = 4;
        $estagio->locatario_id    = 1;
        $estagio->created_at	  = Carbon::now();
        $estagio->updated_at	  = Carbon::now();
        $estagio->save();

        $estagio           		  = new $estagio_model;
        $estagio->descricao       = 'Feito';
        $estagio->ordem      	  = 5;
        $estagio->locatario_id    = 1;
        $estagio->created_at	  = Carbon::now();
        $estagio->updated_at	  = Carbon::now();
        $estagio->save();

        $status_projeto           		  = new $status_projeto_model;
        $status_projeto->descricao       = 'Planejamento';
        $status_projeto->locatario_id    = 1;
        $status_projeto->created_at	  = Carbon::now();
        $status_projeto->updated_at	  = Carbon::now();
        $status_projeto->save();

        $status_projeto           		  = new $status_projeto_model;
        $status_projeto->descricao       = 'Ativo';
        $status_projeto->locatario_id    = 1;
        $status_projeto->created_at	  = Carbon::now();
        $status_projeto->updated_at	  = Carbon::now();
        $status_projeto->save();

        $status_projeto           		  = new $status_projeto_model;
        $status_projeto->descricao       = 'Suspenso';
        $status_projeto->locatario_id    = 1;
        $status_projeto->created_at	  = Carbon::now();
        $status_projeto->updated_at	  = Carbon::now();
        $status_projeto->save();

        $status_projeto           		  = new $status_projeto_model;
        $status_projeto->descricao       = 'Cancelado';
        $status_projeto->locatario_id    = 1;
        $status_projeto->created_at	  = Carbon::now();
        $status_projeto->updated_at	  = Carbon::now();
        $status_projeto->save();

        $status_projeto           		  = new $status_projeto_model;
        $status_projeto->descricao       = 'Encerrado';
        $status_projeto->locatario_id    = 1;
        $status_projeto->created_at	  = Carbon::now();
        $status_projeto->updated_at	  = Carbon::now();
        $status_projeto->save();



        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}