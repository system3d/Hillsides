<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Estagio_Default as esdef;
use App\Status_Projeto_Default as spd;
use App\Tipo_Tarefa_Default as trd;

class SettingsController extends Controller
{
    public function gravarEstagio(request $request){
    	$value = ucfirst($request['value']);
    	$last = esdef::orderBy('ordem', 'desc')->first();
    	$data = array(
    		'descricao'    => $value,
    		'locatario_id' => access()->user()->locatario_id,
    		'ordem'        => ($last->ordem + 1)
		);
		$check = esdef::where('descricao', $value)->first();
		if(!empty($check->id)){
			$response['msg'] = 'Este nome ja esta sendo usado';
			$response['status'] = 'error';
			return $response;
		}
		$new = esdef::create($data);
		if($new){
			$response['status'] = 'success';
			$response['msg'] = 'Estágio Adicionado com Sucesso';
			$response['id']  = $new->id;
			$response['desc'] = $new->descricao;
		}else{
			$response['msg'] = 'Erro ao Adicionar Estágio';
			$response['status'] = 'error';
		}
		return $response;
    }

    public function deleteEstagio(request $request){
    	$dados = $request->all();
    	$id = $dados['id'];
    	$new = esdef::find($id)->delete();
    	if($new){
			$response['status'] = 'success';
			$response['msg'] = 'Estágio Deletado com Sucesso';
		}else{
			$response['msg'] = 'Erro ao Deletar Estágio';
			$response['status'] = 'error';
		}
		return $response;
    }

     public function gravarStp(request $request){
     	$value = ucfirst($request['value']);
    	$data = array(
    		'descricao'    => $value,
    		'locatario_id' => access()->user()->locatario_id
		);
		$check = spd::where('descricao', $value)->first();
		if(!empty($check->id)){
			$response['msg'] = 'Este nome ja esta sendo usado';
			$response['status'] = 'error';
			return $response;
		}
		$new = spd::create($data);
		if($new){
			$response['status'] = 'success';
			$response['msg'] = 'Status Adicionado com Sucesso';
			$response['id']  = $new->id;
			$response['desc'] = $new->descricao;
		}else{
			$response['msg'] = 'Erro ao Adicionar Status';
			$response['status'] = 'error';
		}
		return $response;
     }

     public function deleteStp(request $request){
    	$dados = $request->all();
    	$id = $dados['id'];
    	$new = spd::find($id)->delete();
    	if($new){
			$response['status'] = 'success';
			$response['msg'] = 'Status Deletado com Sucesso';
		}else{
			$response['msg'] = 'Erro ao Deletar Status';
			$response['status'] = 'error';
		}
		return $response;
    }

    public function gravarTrp(request $request){
     	$value = ucfirst($request['value']);
    	$data = array(
    		'descricao'    => $value,
    		'locatario_id' => access()->user()->locatario_id,
    		'icone'        => 'default.png'
		);
		$check = trd::where('descricao', $value)->first();
		if(!empty($check->id)){
			$response['msg'] = 'Este nome ja esta sendo usado';
			$response['status'] = 'error';
			return $response;
		}
		$new = trd::create($data);
		if($new){
			$response['status'] = 'success';
			$response['msg'] = 'Tipo Adicionado com Sucesso';
			$response['id']  = $new->id;
			$response['desc'] = $new->descricao;
		}else{
			$response['msg'] = 'Erro ao Adicionar STipotatus';
			$response['status'] = 'error';
		}
		return $response;
     }

     public function deleteTrp(request $request){
    	$dados = $request->all();
    	$id = $dados['id'];
    	$new = trd::find($id)->delete();
    	if($new){
			$response['status'] = 'success';
			$response['msg'] = 'Tipo Deletado com Sucesso';
		}else{
			$response['msg'] = 'Erro ao Deletar Tipo';
			$response['status'] = 'error';
		}
		return $response;
    }

    public function setOrder(request $request){
    	$dados = $request['sorted'];
    	$ordem = 1;
    	foreach($dados as $dado){
    		$id = str_replace('EsO', '', $dado);
    		$data = array('ordem' => $ordem);
    		$new = esdef::find($id)->update($data);
    		$ordem++;
    	}
    }

    public function setIcon(request $request){
    	$id = $request['id'];
    	$tarefa = trd::find($id);
    	return view('backend.modals.settings.icon', compact('tarefa'));
    }

    public function storeIcon(request $request){
    	$dados = $request->all();
    	$image = $dados['icon'];
    	$tarefa = trd::find($dados['tarefa']);
		 $exts = array('jpg', 'jpeg', 'png', 'gif', 'jpe', 'jif', 'jfif', 'jfi');
	        $extension = $image->getClientOriginalExtension();
	        if(!in_array($extension, $exts)){
	           $response['msg'] = 'Extensão Invalida';
			   $response['status'] = 'error';
			   return $response;
	        }
	    $name = $tarefa->id.'default.'.$extension;
	    $path = 'public/img/icones/';
	    $request->file('icon')->move($path, $name);
	 	if(file_exists($path.$name)){
	 		$toUp = array('icone' => $name);
	 		$tarefa->update($toUp);
	 		if($tarefa){
	 			$response['msg'] = 'Icone Atualizado com Sucesso';
		    	$response['status'] = 'success';
		    	$response['img'] =  asset('img/icones/'.$name);
		    	$response['idt'] = $tarefa->id;
	 		}
	 	}else{
	 	    $response['msg'] = 'Error ao salvar imagem';
		    $response['status'] = 'error';
	 	}
	 	return $response;
    }
}
