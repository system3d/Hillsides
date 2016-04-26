<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kanban;
use App\Events\KanbanEvent;
use App\Tarefa as task;
use App\Models\Access\User\User as user;
use App\Estagio as est;
use Event;

class KanbanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public static function taskUpdate($task, $origem, $destino, $user)
    {
        $usuario = user::find($user);
        $task = task::find($task);
        if($origem != 1 && $origem != 2)
        $orig = est::find($origem);
        if($destino != 1 && $destino != 2)
        $dest = est::find($destino);
        $origName = ($origem == 1) ? 'Backlog' : ($origem == 2 ? 'Arquivada' : $orig->descricao);
        $destName = ($destino == 1) ? 'Backlog' : ($destino == 2 ? 'Arquivada' : $dest->descricao);
        $notify = $usuario->name.' Atualizou: <br/>'.$task->descricao.'<br/> De: '.$origName.'<br/> Para: '.$destName;
        Event::fire(new KanbanEvent('move',$task->id,$destino,$notify,$user,$task->projeto_id));
    }

    public static function configUpdate($type, $user, $project)
    {
        $usuario = user::find($user);
        $notify = $usuario->name.' Atualizou as configurações de '.$type.'. <br/> Para as atualizações serem aplicadas, a página precisa ser atualizada. <br/> <h3 style="text-align:center"></h3>';
        Event::fire(new KanbanEvent('config',false,false,$notify,$user,$project));
    }

     public function register()
    {
        //
    }
}
