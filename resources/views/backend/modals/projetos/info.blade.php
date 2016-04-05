<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>{{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
   <div class="row">
   		<div class="col-md-6">
           <div class="form-group">
               <label class="control-label">Nome:</label>
                 <p class="form-static">{{$projeto->descricao}}</p>
           </div>

     <div class="form-group">
         <label class="control-label">Cliente:</label>
        <p class="form-static"><a href="#" data-id='{{$projeto->cliente_id}}' id="cliente-proj-info">{{$projeto->cliente->razao}}</a></p>
     </div>

		<div class="form-group">
           <label class="control-label">Descrição:</label>
             <p class="form-static">{{$projeto->obs}}</p>
       </div>

      <br/>

	</div>
       <div class="col-md-6">
      <div class="form-group">
           <label class="control-label">Tipo:</label>
             <p class="form-static">{{$projeto->tipo->descricao}}</p>
       </div>
        <div class="form-group">
           <label class="control-label">Status:</label>
             <p class="form-static">{{$projeto->status->descricao}}</p>
       </div>
        <div class="form-group">
           <label class="control-label">Data de Criação:</label>
             <p class="form-static">{{date("d/m/Y", strtotime($projeto->created_at))}}</p>
       </div>
		</div>
	</div>
  <div class="row">
    <div class="col-md-12">
      <?php $fav = ($projeto->favorito == 0) ? 'bg-purple' : 'btn-default-purple';
      $favT = ($projeto->favorito == 0) ? 'Adicionar a Favoritos' : 'Remover de Favoritos'; ?>
        <div class="form-group">
            <button class="btn {{$fav}} projeto-favorite" data-toggle="tooltip" data-html="true" title='{{$favT}}' data-id="{{$projeto->id}}"><i class="fa fa-star"></i></button>
            <a href='{{url("kanban")."/".$projeto->id}}' type="button" class="btn btn-success" data-toggle="tooltip" data-html="true" title='Kanbam do Projeto'><i class="fa fa-th-large"></i></a>
            <button type="button" class="btn btn-primary info-edit-projeto" data-id="{{$projeto->id}}" data-toggle="tooltip" data-html="true" title='Editar'><i class="fa fa-pencil"></i></button>
            <button class="btn bg-orange projeto-equipes" data-id="{{$projeto->id}}" data-toggle="tooltip" data-html="true" title='Equipes do Projeto'><i class="fa fa-users" ></i></button>
            <button class="btn btn-info projeto-sprints" data-id="{{$projeto->id}}" data-toggle="tooltip" data-html="true" title='Sprints'><i class="fa fa-refresh" ></i></button>
            <button class="btn bg-maroon projeto-historias" data-id="{{$projeto->id}}" data-toggle="tooltip" data-html="true" title='Historias' id='hist-proj'><i class="fa fa-book"></i></button>
            <button class="btn bg-olive projeto-disciplinas" data-id="{{$projeto->id}}" data-toggle="tooltip" data-html="true" title='Disciplinas'><i class="fa fa-bookmark"></i></i></button>
            <button class="btn btn-github projeto-etapas" data-id="{{$projeto->id}}" data-toggle="tooltip" data-html="true" title='Etapas'><i class="fa fa-map-signs"></i></button>
            <button class="btn btn-danger projeto-delete" data-id="{{$projeto->id}}" data-toggle="tooltip" data-html="true" title='Excluir'><i class="fa fa-trash"></i></button>
            <span class='dropdown'>
                <button class="btn btn-default projeto-config dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-cogs"></i>
                  &nbsp;
                  <i class="fa fa-caret-down"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="#" id="drop-estagio" data-id="{{$projeto->id}}">Estágios do Projeto</a></li>
                  <li><a href="#" id="drop-st-projeto" data-id="{{$projeto->id}}">Status Disponíveis</a></li>
                  <li><a href="#" id="drop-st-tarefa" data-id="{{$projeto->id}}">Status das Tarefas</a></li>
                  <li><a href="#" id="drop-tarefa" data-id="{{$projeto->id}}">Tipos de Tarefas</a></li>
                </ul>
            </span>
            <button data-dismiss="modal" aria-hidden="true" class="btn btn-google pull-right" data-toggle="tooltip" data-html="true" title='Fechar Janela'><i class="fa fa-times"></i></button>
            
            <input type="hidden" id="PD{{$projeto->id}}">
        </div>
    </div>
  </div>
</div>
		 