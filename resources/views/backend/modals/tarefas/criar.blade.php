@if(isset($projeto->historias()->first()->id))
<div class="panel panel-info panel-criar-tarefa">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Criar Tarefa para {{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
    <div class="nav-tabs-custom">
     <ul class="nav nav-tabs">
      <li class="active"><a href="#dados" data-toggle="tab">Dados</a></li>
      <li><a href="#anexos" data-toggle="tab">Anexos</a></li>
      <li><a href="#custo_crono" data-toggle="tab">Custo/Cronograma</a></li>
    </ul>
    <br>
    <form id="tarefa_cadastro" data-parsley-validate="" enctype="multipart/form-data">
    <div class="tab-content">
        <div class="tab-pane active" id='dados'>
     
       <input type="hidden" name="projeto_id" value="{{$projeto->id}}">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
               <label for="fullname" class="control-label">Título <i class="text-red">*</i> :</label>
               <input type="text" class="form-control" required="" data-parsley-trigger="change" name="descricao" style='width:100%'>
            </div>
            <div class="form-group">
               <label for="historia" class="control-label">História <i class="text-red">*</i> :</label>
                 <select class="form-control" required="" style='width:100%' name='historia_id'>
                   @foreach($projeto->historias() as $hist)
                    <option value="{{$hist->id}}">{{$hist->descricao}}</option>
                   @endforeach
                 </select>
            </div>
                 <div class="form-group">
                   <label for="fullname" class="control-label">Descrição <i class="text-red">*</i> :</label>
                      <textarea id="message" rows="3" class="form-control" required='' data-parsley-trigger="keyup" name="obs" style='width:100%'></textarea>
                </div>
          </div>
          <div class="col-md-4">
             <div class="form-group">
               <label for="historia" class="control-label">Categoria:</label>
                 <select class="form-control" style='width:100%' name='tipo_id'>
                   @foreach($projeto->tipos_tarefa as $type)
                    <option value="{{$type->id}}">{{$type->descricao}}</option>
                   @endforeach
                 </select>
            </div>
             <div class="form-group">
               <label for="historia" class="control-label">Estágio:</label>
                 <select class="form-control" style='width:100%' name='estagio_id'>
                  <option value="1">Backlog</option>
                   @foreach($projeto->estagios->sortBy('ordem') as $estg)
                    <option value="{{$estg->id}}">{{$estg->descricao}}</option>
                   @endforeach
                   <option value="2">Arquivada</option>
                 </select>
            </div> 
             <div class="form-group">
               <label for="historia" class="control-label">Status:</label>
                 <select class="form-control" style='width:100%' name='status_id'>
                   @foreach($projeto->status_tarefa as $stat)
                    <option value="{{$stat->id}}">{{$stat->descricao}}</option>
                   @endforeach
                 </select>
            </div> 
            <div class="form-group">
               <label for="fullname" class="control-label">Peso:</label>
               <input type="number" class="form-control" name="peso" style='width:100%'>
            </div>
          </div>
          <div class="col-md-4">
               <div class="form-group">
               <label for="historia" class="control-label">Atribuída A:</label>
                 <select class="form-control" required="" style='width:100%' name='assignee_id'>
                  <option value="0">Ninguém</option>
                   @foreach($users as $user)
                    <option value="{{$user->id}}" <?php if((int) $dados['user'] == $user->id) echo 'selected'; ?>>{{$user->name}}</option>
                   @endforeach
                 </select>
            </div>

             <div class="form-group">
               <label for="historia" class="control-label">Disciplina:</label>
                 <select class="form-control" required="" style='width:100%' name='disciplina_id'>
                  <option value="0">Nenhuma</option>
                   @foreach($projeto->disciplinas as $disc)
                    <option value="{{$disc->id}}" <?php if((int) $dados['dis'] == $disc->id) echo 'selected'; ?>>{{$disc->descricao}}</option>
                   @endforeach
                 </select>
            </div>

             <div class="form-group">
               <label for="historia" class="control-label">Etapa:</label>
                 <select class="form-control" required="" style='width:100%' name='etapa_id'>
                  <option value="0">Nenhuma</option>
                   @foreach($projeto->etapas as $etapa)
                    <option value="{{$etapa->id}}" <?php if((int) $dados['etapa'] == $etapa->id) echo 'selected'; ?>>{{$etapa->descricao}}</option>
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

     
        </div>

       <div class="tab-pane" id='anexos' style='margin-bottom: 15px;'>

            <div class="row">
              <div class="col-md-10">
                <input type="file" class='form-control' name='anexo[]' style='margin-bottom: 5px;'>
                <input type="file" class='form-control hidden' name='anexo[]' style='margin-bottom: 5px;'>
                <input type="file" class='form-control hidden' name='anexo[]' style='margin-bottom: 5px;'>
                <input type="file" class='form-control hidden' name='anexo[]' style='margin-bottom: 5px;'>
                <input type="file" class='form-control hidden' name='anexo[]' style='margin-bottom: 5px;'>
              </div>
            </div>

       </div>
       <div class="tab-pane" id='custo_crono'></div>


         <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <button type="submit" class="btn btn-primary">Gravar</button> 
                  <a href='#'  data-dismiss="modal" aria-hidden="true" class="btn btn-danger">Cancelar</a>
              </div>
          </div>
            
          </div>

    </form>

    </div>
    </div>
   </div>
</div>
@else
  <div class="alert alert-info">
   <div class="alert-heading" style='color:white;background:#00c0ef'>
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-warning"></i> Nenhuma História Cadastrada!</h4>
    <a href="#" class='criar-historia' data-tipo='projeto' data-id='{{$projeto->id}}'>Cadastre uma História</a> em {{$projeto->descricao}} para criar Tarefas.
  </div>
</div>
@endif