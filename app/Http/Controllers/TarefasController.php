<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projeto as proj;
use App\tarefa as task;
use App\Historia as hist;
use App\Equipe as equipe;

class TarefasController extends Controller
{

    public function index(request $request){
        $tarefa = task::find($request['id']);
        $estagioDesc  = ($tarefa->estagio_id == 1) ? 'Backlog' : (($tarefa->estagio_id == 2) ? 'Arquivada' : $tarefa->estagio->descricao);
        return view('backend.modals.tarefas.index', compact('tarefa', 'estagioDesc'));
    }

    public function criar(request $request){
    	$dados = $request->all();
    	$projeto = proj::find($dados['id']);
    	$users = array();
    	$usersIn = array();
    	foreach($projeto->equipes as $equipe){
    		foreach($equipe->users as $membro){
    			if(!in_array($membro->id, $usersIn)){
    				$users[] = $membro;
    				$usersIn[] = $membro->id;
    			}
    			
    		}
    	}
    	$users = collect($users);
    	return view('backend.modals.tarefas.criar', compact('projeto', 'users', 'dados'));
    }

    public function store(request $request){
        $dados = $request->all();
        $checkName = task::where('descricao',$dados['descricao'])->where('historia_id',$dados['historia_id'])->first();
        if(isset($checkName->id)){
            $response['msg'] = 'Esta Tarefa já existe nesta história.';
            $response['status'] = 'error';
            return $response;
        }
        $historia = hist::find($dados['historia_id']);
        if(empty($historia->id)){
            $response['msg'] = 'História Inválida.';
            $response['status'] = 'error';
            return $response;
        }
        $data = array(
           'descricao'      => $dados['descricao'],
           'obs'            => $dados['obs'],
           'sprint_id'      => $historia->sprint_id,
           'historia_id'    => $dados['historia_id'],
           'tipo_id'        => $dados['tipo_id'],
           'estagio_id'     => $dados['estagio_id'],
           'status_id'      => $dados['status_id'],
           'user_id'        => access()->user()->id,
           'locatario_id'   => access()->user()->locatario_id,
           'projeto_id'     => $dados['projeto_id'],
        );
        if($dados['assignee_id'] != 0) $data['assignee_id'] = $dados['assignee_id'];
        if($dados['disciplina_id'] != 0) $data['disciplina_id'] = $dados['disciplina_id'];
        if($dados['etapa_id'] != 0) $data['etapa_id'] = $dados['etapa_id'];
        if($dados['peso'] != 0) $data['peso'] = $dados['peso'];
         $new = task::create($data);
         if(!isset($new)){
            $response['msg'] = 'Erro ao Gravar Tarefa';
            $response['status'] = 'error';
        }else{
             $response['msg'] = 'Tarefa Criada com Sucesso.';
            $response['status'] = 'success';
            $response['id'] = $new->id;
        }
        return $response;
    }

    public function getTarefas(request $request){
        $dados = $request->all();
        $params = array();
        if($dados['sprint'] != 0){
            $params[] = array('name' => 'sprint_id', 'value' => $dados['sprint']);
        }
        if($dados['story'] != 0){
            $params[] = array('name' => 'historia_id', 'value' => $dados['story']);
        }
        if($dados['user'] != 0){
            $params[] = array('name' => 'assignee_id', 'value' => $dados['user']);
        }
        if($dados['dis'] != 0){
            $params[] = array('name' => 'disciplina_id', 'value' => $dados['dis']);
        }
        if($dados['etapa'] != 0){
            $params[] = array('name' => 'etapa_id', 'value' => $dados['etapa']);
        }
        $tarefas = task::select('id')->where('projeto_id', $dados['projeto']);


        if(count($params) > 0){
            foreach($params as $param){
                $tarefas->where($param['name'], $param['value']);
            }
        }

        if($dados['equipe'] != 0){
           $equipe = equipe::find($dados['equipe']);
           $members = array();
           foreach($equipe->users as $member){
              $members[] = $member->id;
           }
           $tarefas->whereIn('assignee_id', $members);
        }

       $tasks =  $tarefas->orderBy('created_at')->get();
       $response=array();
       $taskes = array();
       if($tasks->count() > 0){
         foreach($tasks as $task){
           $taskes[] = $this->getTarefa($task->id);
         }
       }
       $response['tasks'] = $taskes;
       $response['count'] = $tasks->count();
       return json_encode($response);
       
    }

    public function getTarefaSingle(request $request){
        $response = $this->getTarefa($request['id']);
        return json_encode($response);
    }

    public function moved(request $request){
        $dados = $request->all();
        // return '405';
        $task = task::find($dados['id']);
        $toUp = array('estagio_id' => $dados['estagio']);
        $task->update($toUp);
        return '200';
    }

    private function getTarefa($id){
        $task = task::find($id);
        $estagioDesc  = ($task->estagio_id == 1) ? 'Backlog' : (($task->estagio_id == 2) ? 'Arquivada' : $task->estagio->descricao);
        $response = array(
            'historia_id' => $task->historia_id,
            'estagio_id'  => $task->estagio_id,
            'id'          => $task->id,
            'assignee_id' => !empty($task->assignee_id) ? $task->assignee->id : 0,
            'assignee'    => !empty($task->assignee_id) ? $task->assignee->name : 'Sem Encarregado',
            'etapa'       => !empty($task->etapa_id) ? $task->etapa->descricao : '<br/>',
            'disciplina'  => !empty($task->disciplina_id) ? $task->disciplina->descricao : '<br/>',
            'historia'    => $task->historia->descricao,
            'sprint'      => $task->sprint->descricao,
            'tarefa'      => $task->descricao,
            'status'      => $task->status->descricao,
            'estagio'     => $estagioDesc,
            'tipo'        => $task->tipo->descricao,
            'cor'         => $task->tipo->cor,
            'obs'         => $task->obs,
            'peso'        => $task->peso,
            'tipo_icone'  => asset('img/icones/'.$task->tipo->icone),
            'user_icone'  => !empty($task->assignee_id) ? asset('img/avatar/'.$task->assignee->avatar) : asset('img/avatar/default.png')
        );
       return $response;
    }
}
