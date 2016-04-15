<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projeto as proj;
use App\tarefa as task;
use App\Historia as hist;
use App\Equipe as equipe;
use App\Anexo as anexo;
use App\Models\Access\User\User as user;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Cronograma as crono;
use App\Custo as custo;

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

          if(!empty($dados['crono_prev']) || !empty($dados['crono_real'])){
            $prev = !empty($dados['crono_prev']) ?  date_format(date_create_from_format('d/m/Y', $dados['crono_prev']), 'Y-m-d') : '';
            $real = !empty($dados['crono_real']) ?  date_format(date_create_from_format('d/m/Y', $dados['crono_real']), 'Y-m-d') : '';
            $cronoToSave = array('previsto' => $prev, 'realizado' => $real, 'tarefa_id' => $new->id, 'user_id' => $new->user_id, 'locatario_id' => $new->locatario_id);
            $crono = crono::create($cronoToSave);
          }

          if(!empty($dados['custo'])){
            $custo = $dados['custo'];
            $tipo_custo = $dados['tipo_custo'];
            $custoToSave = array('valor' => $custo, 'tipo_id' => $tipo_custo, 'tarefa_id' => $new->id, 'user_id' => $new->user_id, 'locatario_id' => $new->locatario_id);
            $custoSaved = custo::create($custoToSave);
          }

          $imgError = array();
          if(!empty($dados['anexo'][0])){
            $files = $dados['anexo'];
            $anexo = 1;
            
            foreach($files as $file){
              if(isset($file)){
                  $exts = array('jpg', 'jpeg', 'png', 'gif', 'jpe', 'jif', 'jfif', 'jfi','pdf','txt','zip','doc','rar','xls','ppt','xlsx','pptx');
                  $extension = $file->getClientOriginalExtension();
                  $fileSize = $file->getSize();
                    if(!in_array($extension, $exts)){
                       $imgError[] = 'Extensão Invalida - '.$extension;
                    }else{
                      $finalName = $file->getClientOriginalName();
                      $checkAnexo = anexo::where('tarefa_id',$new->locatario_id)->where('descricao',$finalName)->first();
                      if(!isset($checkAnexo->id)){
                        $anexo++;
                        $path = 'anexos/'.$data['locatario_id'].'/'.$data['projeto_id'].'/'.$new->id.'/';
                        $checking = Storage::put( $path.$finalName, File::get($file));
                         if(isset($checking)){
                          $nameFinal = $path.$finalName;
                          $appended = array('path' => $nameFinal, 'descricao' => $finalName, 'tarefa_id' => $new->id, 'locatario_id' => $new->locatario_id, 'tamanho' => $fileSize);
                          $anexoD = anexo::create($appended);
                         }
                       }else{
                         $imgError[] = 'Arquivo Repetido - '.$finalName;
                       }
                    }
                  }
                }
          }

            $response['msg'] = 'Tarefa Criada com Sucesso.';
            if(count($imgError) > 0){
              foreach($imgError as $imerr){
                $response['msg'] .= ' - '.$imerr;
              }
            }
            $response['status'] = 'success';
            $response['id'] = $new->id;
            $response['story'] = $new->historia_id;
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

    public function editar(request $request){
         $id = $request['id'];
        $tarefa = task::find($id);
        $projeto = $tarefa->projeto;
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
        return view('backend.modals.tarefas.editar', compact('tarefa','projeto','users'));
    }

    public function update(request $request){
         $Alldados = $request->all();
        $dadosBefore = urldecode($Alldados['dados']);
        $dados = explode('&', $dadosBefore);
        foreach($dados as $dado){
            $check2 = explode('=',$dado);
            if($check2[1] != ''){
              $check[$check2[0]] = $check2[1];
            }
        } 
        $id = $check['id'];
        unset($check['id']);
        if($check['assignee_id'] == 0)
          unset($check['assignee_id']);
        if($check['disciplina_id'] == 0)
          unset($check['disciplina_id']);
        if($check['etapa_id'] == 0)
          unset($check['etapa_id']);

        $crono_prev = $check['crono_prev'];
        $crono_real = $check['crono_real'];
        $custo = $check['custo'];
        $tipo_custo = $check['tipo_custo'];
        unset($check['crono_prev']);
        unset($check['crono_real']);
        unset($check['custo']);
        unset($check['tipo_custo']);

        $task = task::find($id);

        
        
        if(isset($task->cronograma)){
          $cronoUp = crono::find($task->cronograma->id);
          $cronoUpdate = array('previsto' => date_format(date_create_from_format('d/m/Y', $crono_prev), 'Y-m-d'), 'realizado' => date_format(date_create_from_format('d/m/Y', $crono_real), 'Y-m-d'));
          $cronoUp->update($cronoUpdate);
        }else{
          $cronoToSave = array('previsto' => date_format(date_create_from_format('d/m/Y', $crono_prev), 'Y-m-d'), 'realizado' => date_format(date_create_from_format('d/m/Y', $crono_real), 'Y-m-d'),
           'tarefa_id' => $task->id, 'user_id' => $task->user_id, 'locatario_id' => $task->locatario_id);
          $cronoNew = crono::create($cronoToSave);
        }

        
        
        if(isset($task->custo)){
          $custoUp = custo::find($task->custo->id);
          $custoUpdate = array('valor' => $custo, 'tipo_id' => $tipo_custo);
          $custoUp->update($custoUpdate);
        }else{
           $custoToSave = array('valor' => $custo, 'tipo_id' => $tipo_custo, 'tarefa_id' => $task->id, 'user_id' => $task->user_id, 'locatario_id' => $task->locatario_id);
           $custoSaved = custo::create($custoToSave);
        }

        $new = $task->update($check);
        if(!isset($new)){
          $response['msg'] = 'Erro ao Atualizar Tarefa';
          $response['status'] = 'error';
        }else{
          $response['msg'] = 'Tarefa Atualizada com Sucesso';
          $response['status'] = 'success';
          $response['id'] = $id;
          $response['task'] = $this->getTarefa($id);
        }
        
         return $response;
    }

    public function excluir(request $request){
    $id = $request['id'];
    $new = task::find($id);
    if($new->anexos->count() > 0){
        $path = storage_path().'/app/anexos/'.$new->locatario_id.'/'.$new->projeto_id.'/'.$new->id;
        $Ruin = File::deleteDirectory($path);
    }
    $idgo = $new->id;
    $new->delete();
    $response['msg'] = 'Tarefa Excluida com Sucesso';
    $response['status'] = 'success';
    $response['id'] = $idgo;
    return $response;
  }

  public function user(request $request){
     $id = $request['id'];
     $task = $request['task'];
     $user = user::find($id);
     $tarefa = task::find($task);
     return view('backend.modals.tarefas.user', compact('user','tarefa'));
  }

  public function anexos(request $request){
    $tarefa = task::find($request['id']);
    return view('backend.modals.tarefas.anexos', compact('tarefa'));
  }

  public function download($id){
    $file = anexo::find($id);
    return response()->download(storage_path().'/app/'.$file->path);
  }

   public function excluirAnexo(request $request){
    $id = $request['id'];
    $new = anexo::find($id);
    File::delete(storage_path().'/app/'.$new->path);
    $idgo = $new->tarefa_id;
    $new->delete();
    $response['msg'] = 'Anexo Excluido com Sucesso';
    $response['status'] = 'success';
    $response['task'] = $this->getTarefa($idgo);
    $response['id'] = $idgo;
    return $response;
  }

  public function anexoUpload(request $request){
     $id = $request['id'];
     $tarefa = task::find($id);
     return view('backend.modals.tarefas.anexos_upload', compact('tarefa'));
  }

  public function storeAnexo(request $request){
    $file = $request['anexo'];
    $new = task::find($request['tarefa']);
    $idgo = $new->id;
    $exts = array('jpg', 'jpeg', 'png', 'gif', 'jpe', 'jif', 'jfif', 'jfi','pdf','txt','zip','doc','rar','xls','ppt','xlsx','pptx');
    $extension = $file->getClientOriginalExtension();
    $fileSize = $file->getSize();
      if(!in_array($extension, $exts)){
          $response['status'] = 'error';
          $response['msg'] = 'Extensão Invalida';
          return $response;
      }else{
        $finalName = $file->getClientOriginalName();
        $checkAnexo = anexo::where('tarefa_id',$new->locatario_id)->where('descricao',$finalName)->first();
        if(!isset($checkAnexo->id)){
          $path = 'anexos/'.$new->locatario_id.'/'.$new->projeto_id.'/'.$new->id.'/';
          $checking = Storage::put( $path.$finalName, File::get($file));
           if(isset($checking)){
            $nameFinal = $path.$finalName;
            $appended = array('path' => $nameFinal, 'descricao' => $finalName, 'tarefa_id' => $new->id, 'locatario_id' => $new->locatario_id, 'tamanho' => $fileSize);
            $anexoD = anexo::create($appended);
            $response['msg'] = 'Anexo Salvo com Sucesso';
            $response['status'] = 'success';
            $response['task'] = $this->getTarefa($idgo);
            $response['id'] = $idgo;
            return $response;
           }
         }else{
           $response['status'] = 'error';
          $response['msg'] = 'Arquivo Repetido';
          return $response;
         }
      }
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
            'user_icone'  => !empty($task->assignee_id) ? asset('img/avatar/'.$task->assignee->avatar) : asset('img/avatar/default.png'),
            'anexos'      => $task->anexos->count() > 0 ? '<span class="label bg-aqua pull-right" data-toggle="tooltip" data-html="true" title="Esta Tarefa Possui Anexos">'.$task->anexos->count().'</span>' : ''
        );
       return $response;
    }

}
