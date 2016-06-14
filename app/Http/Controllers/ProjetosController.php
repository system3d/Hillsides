<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Projeto as proj; 
use App\Tipo_Projeto as tproj;
use App\Estagio_Default as esdef;
use App\Status_Projeto_Default as spd;
use App\Status_Tarefa_Default as sfd;
use App\Tipo_Tarefa_Default as trd;
use App\Estagio as es;
use App\Status_Projeto as sp;
use App\Status_Tarefa as sf;
use App\Tipo_Tarefa as tr;
use App\Equipe as equipe;
use App\Sprint as sprint;
use App\historia as historia;
use App\Disciplina as disc;
use App\Etapa as etapa;
use App\Tarefa as task;
use App\Cronograma as crono;
use App\Custo as custo;
use App\Anexo as anexo;

class ProjetosController extends Controller
{
    public function index(){
    	
    	return view('backend.projetos');
    }

     public function criar(){
     	$tipos = tproj::all();
      return view('backend.modals.projetos.criar', compact('tipos'));
   }

   public function info(request $request){
      $projeto = proj::find($request['id']);
      $kanban = true;
      if(isset($request['kanban'])){
        if($request['kanban'] == 'nao'){
          $kanban = false;
        }
      }
      return view('backend.modals.projetos.info', compact('projeto', 'kanban'));
   }

   public function store(request $request){
	$Alldados = $request->all();
   	$dadosBefore = urldecode($Alldados['dados']);
   	$dados = explode('&', $dadosBefore);
   	foreach($dados as $dado){
        $check2 = explode('=',$dado);
        if($check2[1] != ''){
        	$check[$check2[0]] = $check2[1];
        }
    } 
   	$check['locatario_id'] = access()->user()->locatario_id;
    $check['user_id']   = access()->user()->id;
    $status = $check['status_id'];
    unset($check['status_id']);

    $new = proj::create($check);
     if(!isset($new)){
    	$response['msg'] = 'Erro ao Gravar Projeto';
		$response['status'] = 'error';
		return $response;
    }
    $est_def = esdef::all();
    foreach($est_def as $ed){
    	$ests = array(
    		'descricao'    => $ed->descricao,
    		'ordem'        => $ed->ordem,
    		'projeto_id'   => $new->id,
    		'locatario_id' => $check['locatario_id']
		);
		$newEs = es::create($ests);
    }

    
    if(!isset($newEs)){
    	$response['msg'] = 'Erro na criação dos Estágios do Projeto';
		$response['status'] = 'error';
		return $response;
    }

    $stp_def = spd::all();
    $stps1 = array(
        'descricao'    => 'Ativo',
        'projeto_id'   => $new->id,
        'user_id'      => $check['user_id'],
        'locatario_id' => $check['locatario_id']
    );
    $newSTs1 = sp::create($stps1);
    foreach($stp_def as $pd){
    	$stps = array(
    		'descricao'    => $pd->descricao,
    		'projeto_id'   => $new->id,
    		'user_id'      => $check['user_id'],
    		'locatario_id' => $check['locatario_id']
		);
		$newSTs = sp::create($stps);
    }
    
    if(!isset($newSTs)){
    	$response['msg'] = 'Erro na criação dos Status do Projeto';
		$response['status'] = 'error';
		return $response;
    }
    if($status == '0'){
      $statusNewQ = sp::where('descricao', 'Ativo')->where('projeto_id',$new->id)->first();
    }else{
      $statusOld = spd::find($status);
      $statusNewQ = sp::where('descricao', $statusOld->descricao)->where('projeto_id',$new->id)->first();
    }
    $statusNew = array('status_id' => $statusNewQ->id);
    $newU = $new->update($statusNew);
    if(!$newU){
    	$response['msg'] = 'Erro ao atribuir Status ao Projeto';
		$response['status'] = 'error';
		return $response;
    }
   	
   	$stf_def = sfd::all();
    $stfs2 = array(
        'descricao'    => 'Aberta',
        'projeto_id'   => $new->id,
        'locatario_id' => $check['locatario_id']
    );
     $newSFs2 = sf::create($stfs2);
    foreach($stf_def as $fd){
    	$stfs = array(
    		'descricao'    => $fd->descricao,
    		'projeto_id'   => $new->id,
    		'locatario_id' => $check['locatario_id']
		);
		 $newSFs = sf::create($stfs);
    }
   
    if(!isset($newSFs)){
    	$response['msg'] = 'Erro na criação dos Status de Tarefas do Projeto';
		$response['status'] = 'error';
		return $response;
    }

    $str_def = trd::all();
    $stfrs2 = array(
        'descricao'    => 'Sem Classificação',
        'icone'        => 'default.png',
        'cor'          => '#fff',
        'projeto_id'   => $new->id,
        'locatario_id' => $check['locatario_id']
    );
    $newSFRs2 = tr::create($stfrs2);
    foreach($str_def as $fr){
    	$stfrs = array(
    		'descricao'    => $fr->descricao,
    		'icone'        => $fr->icone,
        'cor'          => $fr->cor,
    		'projeto_id'   => $new->id,
    		'locatario_id' => $check['locatario_id']
		);
		$newSFRs = tr::create($stfrs);
    }
    
    if(!isset($newSFRs)){
    	$response['msg'] = 'Erro na criação dos Tipos de Tarefas do Projeto';
		$response['status'] = 'error';
		return $response;
    }

    $response['msg'] = 'Projeto Criado com Sucesso';
	$response['status'] = 'success';
	return $response;
	
   }

   public function teamplate(request $request){
      $Alldados = $request->all();
      $dadosBefore = urldecode($Alldados['dados']);
      $dados = explode('&', $dadosBefore);
      foreach($dados as $dado){
          $check2 = explode('=',$dado);
          if($check2[1] != ''){
            $check[$check2[0]] = $check2[1];
          }
      }
      $user_id = access()->user()->id;
      $loc_id = access()->user()->locatario_id;
      $checkName = proj::where('descricao',$check['descricao'])->first();
      if(isset($checkName->id)){
        $response['msg'] = 'Nome em uso.';
        $response['status'] = 'error';
        return $response;
      }
      $teamplate = proj::find($check['teamplate-id']);
      if(!isset($teamplate->id)){
          $response['msg'] = 'Teamplate inválido';
          $response['status'] = 'error';
          return $response;
      }
      $projData = array(
          'descricao'  => $check['descricao'],
          'obs'        => $check['obs'],
          'cliente_id' => $check['cliente_id'],
          'tipo_id'    => tproj::where('descricao','Projeto')->first()->id,
          'user_id'    => $user_id,
          'locatario_id' => $loc_id,
          'favorito'   => 0
      );
      $proj = proj::create($projData);
      $status = $teamplate->status_id;    

      if(!$proj->id){
        $response['msg'] = 'Erro ao criar novo Projeto.';
        $response['status'] = 'error';
        return $response;
      }
      $pro_id = $proj->id;
      //Status de Projeto
      foreach($teamplate->statuses as $stats){
        $statData = array(
          'descricao'    => $stats->descricao,
          'user_id'      => $user_id,
          'locatario_id' => $loc_id,
          'projeto_id'   => $pro_id
        );
        sp::create($statData);
      }

      if($status == '0'){
          $statusNewQ = sp::where('descricao', 'Ativo')->where('projeto_id',$proj->id)->first();
        }else{
          $statusOld = sp::find($status);
          $statusNewQ = sp::where('descricao', $statusOld->descricao)->where('projeto_id',$proj->id)->first();
        }
        $statusNew = array('status_id' => $statusNewQ->id);
        $newU = $proj->update($statusNew);
        if(!$newU){
          $response['msg'] = 'Erro ao atribuir Status ao Projeto';
        $response['status'] = 'error';
        return $response;
      }

      //Status de Tarefas
      $task_stat = array();
      foreach($teamplate->status_tarefa as $stats){
        $statData = array(
          'descricao'    => $stats->descricao,
          'locatario_id' => $loc_id,
          'projeto_id'   => $pro_id
        );
        $sft = sf::create($statData);
        $task_stat[$stats->id] = $sft->id;
      }
      //Tipos de Tarefas
      $task_tipos = array();
      foreach($teamplate->tipos_tarefa as $stats){
        $statData = array(
          'descricao'    => $stats->descricao,
          'icone'        => $stats->icone,
          'cor'          => $stats->cor,
          'user_id'      => $user_id,
          'locatario_id' => $loc_id,
          'projeto_id'   => $pro_id
        );
        $ttipo = tr::create($statData);
        $task_tipos[$stats->id] = $ttipo->id;
      }
      //Estagios
      $task_est = array();
      foreach($teamplate->estagios as $stats){
        $statData = array(
          'descricao'    => $stats->descricao,
          'ordem'        => $stats->ordem,
          'locatario_id' => $loc_id,
          'projeto_id'   => $pro_id
        );
        $estt = es::create($statData);
        $task_est[$stats->id] = $estt->id;
      }
       //Disciplinas
      $task_dist = array();
      foreach($teamplate->disciplinas as $stats){
        $statData = array(
          'descricao'    => $stats->descricao,
          'obs'          => $stats->obs,
          'user_id'      => $user_id,
          'locatario_id' => $loc_id,
          'projeto_id'   => $pro_id
        );
        $disct = disc::create($statData);
        $task_dist[$stats->id] = $disct->id;
      }
      //Etapa
      $task_etapa = array();
      foreach($teamplate->etapas as $stats){
        $statData = array(
          'descricao'    => $stats->descricao,
          'obs'          => $stats->obs,
          'user_id'      => $user_id,
          'locatario_id' => $loc_id,
          'projeto_id'   => $pro_id
        );
        $etapat = etapa::create($statData);
        $task_etapa[$stats->id] = $etapat->id;
      }
      //Sprint
      foreach($teamplate->sprints as $stats){
        $statData = array(
          'descricao'    => $stats->descricao,
          'obs'          => $stats->obs,
          'inicio'       => $stats->inicio,
          'termino'      => $stats->termino,
          'custo'        => $stats->custo,
          'user_id'      => $user_id,
          'locatario_id' => $loc_id,
          'projeto_id'   => $pro_id
        );
        $sprinto = sprint::create($statData);
        foreach($stats->historias as $hist){
          $statData = array(
          'descricao'    => $hist->descricao,
          'obs'          => $hist->obs,
          'user_id'      => $user_id,
          'locatario_id' => $loc_id,
          'sprint_id'    => $sprinto->id
        );
          $this_hist = historia::create($statData);
          foreach($hist->tarefas as $tar){
            $t_disc = !empty($tar->disciplina_id) ? $task_dist[$tar->disciplina_id] : null;
            $t_etapa = !empty($tar->etapa_id) ? $task_etapa[$tar->etapa_id] : null;
            $t_est = $tar->estagio_id == 2 ? 2 : ($tar->estagio_id == 1 ? 1 : $task_est[$tar->estagio_id]);
            $statData = array(
              'descricao'    => $tar->descricao,
              'obs'          => $tar->obs,
              'user_id'      => $user_id,
              'locatario_id' => $loc_id,
              'sprint_id'    => $sprinto->id,
              'historia_id'  => $this_hist->id,
              'assignee_id'  => $tar->assignee_id,
              'tipo_id'      => $task_tipos[$tar->tipo_id],
              'estagio_id'   => $t_est,
              'status_id'    => $task_stat[$tar->status_id],
              'disciplina_id'=> $t_disc,
              'etapa_id'     => $t_etapa,
              'projeto_id'   => $pro_id
            );
            $tasko = task::create($statData);

            if(isset($tar->cronograma->id)){
              $cronoToSave = array('previsto' => $tar->cronograma->previsto, 'realizado' => $tar->cronograma->realizado, 'tarefa_id' => $tasko->id, 'user_id' => $user_id, 'locatario_id' => $loc_id);
              $crono = crono::create($cronoToSave);
            }

            if(isset($tar->custo->id)){
              $custo = $tar->custo->valor;
              $tipo_custo = $tar->custo->tipo_id;
              $custoToSave = array('valor' => $custo, 'tipo_id' => $tipo_custo, 'tarefa_id' => $tasko->id, 'user_id' => $user_id, 'locatario_id' => $loc_id);
              $custoSaved = custo::create($custoToSave);
            }
            if( ($tar->anexos->count()) > 0 ){
              foreach($tar->anexos as $append){
                $oldPath = 'anexos/'.$loc_id.'/'.$tar->projeto_id.'/'.$tar->id.'/';
                $newPath = 'anexos/'.$loc_id.'/'.$pro_id.'/'.$tasko->id.'/';
                Storage::copy($oldPath.$append->descricao, $newPath.$append->descricao);
                if(Storage::exists($newPath.$append->descricao)){
                   $appended = array('path' => $newPath.$append->descricao, 'descricao' => $append->descricao, 'tarefa_id' => $tasko->id, 'locatario_id' => $loc_id, 'tamanho' => $append->tamanho);
                   $anexoD = anexo::create($appended);
                }
              }
            }

          }
        }
      }
      foreach($teamplate->equipes as $equipe){
        $proj->equipes()->attach($equipe);
      }

      $response['msg'] = 'Projeto Criado com Sucesso';
      $response['status'] = 'success';
      return $response;

   }

   public function getProjetos(request $request){
   	$projetos = proj::all();
	$data = array();
	foreach($projetos as $projeto){
		$data[] = array(
			'nome'     => '<a href="#" class="projeto-info" data-id="'.$projeto->id.'">'.$projeto->descricao.'</a>',
			'desc'     => str_limit($projeto->obs,150),
      'tipo'     => $projeto->tipo->descricao,
			'cliente'  => $projeto->cliente->razao,
			'status'   => $projeto->status->descricao,
      'criado'   => date('d/m/Y', strtotime($projeto->created_at))
		);
	}
	$total = empty($projetos) ? 0 : $projetos->count();
	$response['data'] = $data;
	$response['current'] = 1;
	$response['rowCount'] = 5;
	$response['total'] = $total;

	return $response;
   }

   public function toggleFavorite(request $request){
   	 $id = $request['id'];
   	 $proj = proj::find($id);
   	 $up = ($proj->favorito == 0) ? 1 : 0;
   	 $toUp = array('favorito' => $up);
   	 $proj->update($toUp);
   	 die('success');
   }

   public function editar(request $request){
   	 $id = $request['id'];
   	 $projeto = proj::find($id);
   	 $tipos = tproj::all();
   	 return view('backend.modals.projetos.editar', compact('projeto', 'tipos'));
   }

   public function update(Request $request){
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
    $new = proj::find($id)->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Projeto';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Projeto Atualizado com Sucesso';
      $response['status'] = 'success';
    }
    
     return $response;
  }

  public function excluir(request $request){
    $iid = $request->all();
    $id = $iid['id'];
    $check = sprint::where('projeto_id',$id)->get();
   if(!empty($check->first()->id)){
      $response['msg'] = 'Projetos com Sprints não podem ser excluídos.';
      $response['status'] = 'error';
      return $response;
    }else{
      $deleted = proj::find($id)->delete();
      if($deleted){
        $response['msg'] = 'Projeto Excluído com Sucesso.';
        $response['status'] = 'success';
      }else{
        $response['msg'] = 'Erro ao excluir projeto.';
        $response['status'] = 'error';
      }
      return $response;
    } 
  }

  public function equipes(request $request){
     $id = $request['id'];
     $projeto = proj::find($id);
     $equipes = equipe::all();
     if($projeto->equipes){
       foreach($equipes as $key => $equipe){
          if($projeto->equipes->contains($equipe)){
            $equipes->forget($key);
          }
       }
     }
     return view('backend.modals.projetos.equipes', compact('projeto', 'equipes'));
   }

   public function novaEquipe(request $request){
    $id = $request['id'];
    $pid = $request['proj_id'];
    $projeto = proj::find($pid);
    $equipe = equipe::find($id);
    if(isset($equipe) && isset($projeto))
      $projeto->equipes()->attach($equipe);
    else{
      $response['msg'] = '%error&Erro ao Adicionar Equipe';
      return $response;
    }
      

    $response['msg'] = '%success&Equipe Adicionada com Sucesso';
    $response['id'] =  $pid;
    return $response;
   }

   public function removerEquipe(Request $request){
    $dados = $request->all();
    $id = $dados['id'];
    $eid = $dados['proj_id'];
    $equipe = equipe::find($id);
    $projeto = proj::find($eid);
    if(isset($projeto) && isset($equipe))
      $projeto->equipes()->detach($equipe);
    else{
       $response['msg'] = '%error&Erro ao Remover Equipe';
       return $response;
     }

    $response['msg'] = '%success&Equipe Atualizada com Sucesso';
    $response['id'] = $eid;
    return $response;
  }

  public function sprints(request $request){
    $id = $request['id'];
    $projeto = proj::find($id);
     return view('backend.modals.projetos.sprints', compact('projeto'));
  }

  public function criarSprint(request $request){
    $id = $request['id'];
    $projeto = proj::find($id);
    return view('backend.modals.projetos.criar-sprint', compact('projeto'));
  }

  public function editarSprint(request $request){
    $id = $request['id'];
    $sprint = sprint::find($id);
    return view('backend.modals.projetos.editar-sprint', compact('sprint'));
  }

  public function updateSprint(request $request){
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
    if(!empty($check['inicio']))
        $check['inicio'] = date_format(date_create_from_format('d/m/Y', $check['inicio']), 'Y-m-d');
   if(!empty($check['termino']))
      $check['termino'] = date_format(date_create_from_format('d/m/Y', $check['termino']), 'Y-m-d');
    $sprint = sprint::find($id);
    $new = $sprint->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Sprint';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Projeto Atualizado com Sucesso';
      $response['status'] = 'success';
       $response['id'] = $sprint->projeto_id;
    }
    
     return $response;
  }

  public function excluirSprint(Request $request){
    $id = $request['id'];
    $new = sprint::find($id);
    $proj_id = $new->projeto_id;
    $new->delete();
    $response['msg'] = 'Sprint Excluido com Sucesso';
    $response['status'] = 'success';
    $response['id'] = $proj_id;
    return $response;
  }

  public function historias(request $request){
    $id = $request['id'];
    $tipo = $request['tipo'];
    $force = 0;
    if($tipo == 'sprint'){
      $obj = sprint::find($id);
      $historias = $obj->historias;
    }
    else{
      $obj = proj::find($id);
      $historias = $obj->historias();
    }

    if(isset($request['sprint'])){
      if($request['sprint'] !== '0'){
        $obj = sprint::find($request['sprint']);
        $historias = $obj->historias;
        $tipo = 'sprint';
        $force = 1;
      }  
    }
    return view('backend.modals.projetos.historias', compact('obj','tipo','historias','force'));
  }

  public function criarHistoria(request $request){
    $id = $request['id'];
    $tipo = $request['tipo'];
    $force = $request['force'];
    if($tipo == 'sprint'){
      $obj = sprint::find($id);
      $projeto = $obj->projeto;
    }
    else{
      $obj = proj::find($id);
      $projeto = $obj;
    }
    return view('backend.modals.projetos.criar-historia', compact('obj','tipo','projeto','force'));
  }

  public function editarHistoria(request $request){
    $id = $request['id'];
    $tipo = $request['tipo'];
    $historia = historia::find($id);
    $sprints = $historia->sprint->projeto->sprints;
    return view('backend.modals.projetos.editar-historia', compact('historia','tipo','sprints'));
  }

    public function updateHistoria(request $request){
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
     $tipo = $check['tipo'];
    unset($check['tipo']);

    $historia = historia::find($id);
    $idgo = ($tipo == 'sprint') ? $historia->sprint_id : $historia->sprint->projeto_id;
    $new = $historia->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Historia';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Historia Atualizado com Sucesso';
      $response['status'] = 'success';
       $response['id'] = $idgo;
       $response['tipo'] = $tipo;
    }
    
     return $response;
  }

  public function excluirHistoria(request $request){
    $id = $request['id'];
    $tipo = $request['tipo'];
    $new = historia::find($id);
    $idgo = ($tipo == 'sprint') ? $new->sprint_id : $new->sprint->projeto_id;
    $new->delete();
    $response['msg'] = 'Historia Excluida com Sucesso';
    $response['status'] = 'success';
    $response['id'] = $idgo;
    $response['tipo'] = $tipo;
    return $response;
  }

    public function disciplinas(request $request){
    $id = $request['id'];
   $projeto = proj::find($id);
     return view('backend.modals.projetos.disciplinas', compact('projeto'));
  }

    public function criarDisciplinas(request $request){
    $id = $request['id'];
    $projeto = proj::find($id);
    return view('backend.modals.projetos.criar-disciplina', compact('projeto'));
  }

    public function editarDisciplinas(request $request){
    $id = $request['id'];
    $disciplina = disc::find($id);
    return view('backend.modals.projetos.editar-disciplina', compact('disciplina'));
  }

      public function updateDisciplinas(request $request){
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

    $disciplina = disc::find($id);

    $new = $disciplina->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Disciplina';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Disciplina Atualizado com Sucesso';
      $response['status'] = 'success';
       $response['id'] = $disciplina->projeto_id;
    }
    
     return $response;
  }

   public function excluirDisciplinas(request $request){
    $id = $request['id'];
    $new = disc::find($id);
    $idgo = $new->projeto_id;
    $new->delete();
    $response['msg'] = 'Disciplina Excluida com Sucesso';
    $response['status'] = 'success';
    $response['id'] = $idgo;
    return $response;
  }


  ///////


  public function etapas(request $request){
    $id = $request['id'];
   $projeto = proj::find($id);
     return view('backend.modals.projetos.etapas', compact('projeto'));
  }

    public function criarEtapas(request $request){
    $id = $request['id'];
    $projeto = proj::find($id);
    return view('backend.modals.projetos.criar-etapa', compact('projeto'));
  }

    public function editarEtapas(request $request){
    $id = $request['id'];
    $etapa = etapa::find($id);
    return view('backend.modals.projetos.editar-etapa', compact('etapa'));
  }

      public function updateEtapas(request $request){
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

    $etapa = etapa::find($id);

    $new = $etapa->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Etapa';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Etapa Atualizado com Sucesso';
      $response['status'] = 'success';
       $response['id'] = $etapa->projeto_id;
    }
    
     return $response;
  }

   public function excluirEtapas(request $request){
    $id = $request['id'];
    $new = etapa::find($id);
    $idgo = $new->projeto_id;
    $new->delete();
    $response['msg'] = 'Etapa Excluida com Sucesso';
    $response['status'] = 'success';
    $response['id'] = $idgo;
    return $response;
  }


  ////





}
