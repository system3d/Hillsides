<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Editar {{$tarefa->descricao}}</h4>
   </div>
   <div class="panel-body">
       <form id="tarefa_update" data-parsley-validate="" enctype="multipart/form-data">
       <input type="hidden" name="id" value="{{$tarefa->id}}">
       	<div class="row">
       		<div class="col-md-4">
       			<div class="form-group">
               <label for="fullname" class="control-label">Título <i class="text-red">*</i> :</label>
               <input type="text" class="form-control" required="" data-parsley-trigger="change" name="descricao" style='width:100%' value='{{$tarefa->descricao}}'>
            </div>
            <div class="form-group">
               <label for="historia" class="control-label">História <i class="text-red">*</i> :</label>
                 <select class="form-control" required="" style='width:100%' name='historia_id'>
                   @foreach($projeto->historias() as $hist)
                    <option value="{{$hist->id}}" <?php if($hist->id == $tarefa->historia_id) echo 'selected'; ?>>{{$hist->descricao}}</option>
                   @endforeach
                 </select>
            </div>
                 <div class="form-group">
                   <label for="fullname" class="control-label">Descrição <i class="text-red">*</i> :</label>
                      <textarea id="message" rows="3" class="form-control" required='' data-parsley-trigger="keyup" name="obs" style='width:100%'>{{$tarefa->obs}}</textarea>
                </div>
       		</div>
          <div class="col-md-4">
             <div class="form-group">
               <label for="historia" class="control-label">Categoria:</label>
                 <select class="form-control" style='width:100%' name='tipo_id'>
                   @foreach($projeto->tipos_tarefa as $type)
                    <option value="{{$type->id}}" <?php if($type->id == $tarefa->tipo_id) echo 'selected'; ?>>{{$type->descricao}}</option>
                   @endforeach
                 </select>
            </div>
             <div class="form-group">
               <label for="historia" class="control-label">Estágio:</label>
                 <select class="form-control" style='width:100%' name='estagio_id'>
                  <option value="1" <?php if($tarefa->estagio_id == '1') echo 'selected'; ?>>Backlog</option>
                   @foreach($projeto->estagios->sortBy('ordem') as $estg)
                    <option value="{{$estg->id}}" <?php if($estg->id == $tarefa->estagio_id) echo 'selected'; ?>>{{$estg->descricao}}</option>
                   @endforeach
                   <option value="2" <?php if($tarefa->estagio_id == '2') echo 'selected'; ?>>Arquivada</option>
                 </select>
            </div> 
             <div class="form-group">
               <label for="historia" class="control-label">Status:</label>
                 <select class="form-control" style='width:100%' name='status_id'>
                   @foreach($projeto->status_tarefa as $stat)
                    <option value="{{$stat->id}}" <?php if($stat->id == $tarefa->status_id) echo 'selected'; ?>>{{$stat->descricao}}</option>
                   @endforeach
                 </select>
            </div> 
            <div class="form-group">
               <label for="fullname" class="control-label">Peso:</label>
               <input type="number" class="form-control" name="peso" style='width:100%' value='{{$tarefa->peso}}'>
            </div>
             <div class="form-group">
               <div class="row">
                <div class="col-md-4">
                  <label for="fullname" class="control-label">Custo:</label>
                   <input type="number" class="form-control" name="custo" style='width:100%' value='{{$tarefa->custo->valor}}'>
                </div>
                <div class="col-md-8">
                  <label for="fullname" class="control-label">Tipo de Custo:</label>
                  <select class="form-control" required="" style='width:100%' name='tipo_custo'>
                   @foreach(access()->user()->locatario->tipos_custo as $tpc)
                    <option value="{{$tpc->id}}" <?php if($tarefa->custo->tipo_id == $tpc->id) echo 'selected'; ?>>{{$tpc->descricao}}</option>
                   @endforeach
                 </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                 <label for="fullname" class="control-label">Data Prevista para Início:</label>
                 <input type="text" class="form-control datePicker" name="crono_prev" style='width:100%' value="{{date('d/m/Y',strtotime($tarefa->cronograma->previsto))}}">
              </div>
              <div class="form-group">
                 <label for="fullname" class="control-label">Data Prevista para Término:</label>
                 <input type="text" class="form-control datePicker" name="crono_real" style='width:100%' value="{{date('d/m/Y',strtotime($tarefa->cronograma->realizado))}}">
              </div>
               <div class="form-group">
               <label for="historia" class="control-label">Atribuída A:</label>
                 <select class="form-control" required="" style='width:100%' name='assignee_id'>
                  <option value="0">Ninguém</option>
                   @foreach($users as $user)
                    <option value="{{$user->id}}" <?php if((int) $tarefa->assignee_id == $user->id) echo 'selected'; ?>>{{$user->name}}</option>
                   @endforeach
                 </select>
              </div>

             <div class="form-group">
               <label for="historia" class="control-label">Disciplina:</label>
                 <select class="form-control" required="" style='width:100%' name='disciplina_id'>
                  <option value="0">Nenhuma</option>
                   @foreach($projeto->disciplinas as $disc)
                    <option value="{{$disc->id}}" <?php if((int) $tarefa->disciplina_id == $disc->id) echo 'selected'; ?>>{{$disc->descricao}}</option>
                   @endforeach
                 </select>
            </div>

             <div class="form-group">
               <label for="historia" class="control-label">Etapa:</label>
                 <select class="form-control" required="" style='width:100%' name='etapa_id'>
                  <option value="0">Nenhuma</option>
                   @foreach($projeto->etapas as $etapa)
                    <option value="{{$etapa->id}}" <?php if((int) $tarefa->etapa_id == $etapa->id) echo 'selected'; ?>>{{$etapa->descricao}}</option>
                   @endforeach
                 </select>
            </div>
            <div class="form-group">
              <i>
                Você pode criar Disciplinas e Etapas, assim como atribuir equipes ao projeto, na página <a target='_blank' href="{{url('projetos')}}">Meus Projetos</a>.
              </i>
            </div>
          </div>
       	</div> 

        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <button type="submit" class="btn btn-primary">Atualizar</button> 
                  <a href='#'  id='voltar_modal' class="btn btn-danger">Cancelar</a>
              </div>
          </div>
            
          </div>
        </div>
    </form>
   </div>
</div>
