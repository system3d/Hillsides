<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>{{$tarefa->descricao}}</h4>
   </div>
   <div class="panel-body">
   <div class="row">
   		<div class="col-md-6">
           <div class="form-group">
               <label class="control-label">Nome:</label>
                 <p class="form-static">{{$tarefa->descricao}}</p>
           </div>
           <div class="form-group">
               <label class="control-label">Descrição:</label>
                 <p class="form-static" style='white-space: pre-line'>{{$tarefa->obs}}</p>
           </div>
           <div class="form-group">
               <label class="control-label">História :</label>
               <p class="form-static">{{$tarefa->historia->descricao}}</p>
           </div>
             <br/><br/>
      </div>
      <div class="col-md-3">
         <div class="form-group">
             <label class="control-label">Categoria :</label>
             <p class="form-static">{{$tarefa->tipo->descricao}}</p>
         </div>
         <div class="form-group">
             <label class="control-label">Estágio :</label>
             <p class="form-static">{{$estagioDesc}}</p>
         </div>
          <div class="form-group">
             <label class="control-label">Status :</label>
             <p class="form-static">{{$tarefa->status->descricao}}</p>
         </div>
         @if(!empty($tarefa->peso))
          <div class="form-group">
             <label class="control-label">Peso :</label>
             <p class="form-static">{{$tarefa->peso}}</p>
         </div>
        @endif
         @if(!empty($tarefa->custo->id))
         <div class="form-group">
               <label class="control-label">Custo:</label>
                 <p class="form-static">{{$tarefa->custo->valor}} R$ - {{$tarefa->custo->tipo->descricao}}</p>
           </div>
        @endif
      </div>
      <div class="col-md-3">

       	@if(!empty($tarefa->assignee_id))
		     <div class="form-group">
               <label class="control-label">Encarregado:</label>
                 <p class="form-static">{{$tarefa->assignee->name}}</p>
           </div>
        @endif
       @if(!empty($tarefa->disciplina_id))
		     <div class="form-group">
	               <label class="control-label">Endereço:</label>
	                 <p class="form-static">{{$tarefa->disciplina->descricao}}</p>
	           </div>
	    @endif
        @if(!empty($tarefa->etapa_id))
		     <div class="form-group">
               <label class="control-label">Etapa:</label>
                 <p class="form-static">{{$tarefa->etapa->descricao}}</p>
           </div>
        @endif
        @if(!empty($tarefa->cronograma->previsto))
         <div class="form-group">
               <label class="control-label">Data Prevista para Início:</label>
                 <p class="form-static">{{diffForHumans($tarefa->cronograma->previsto)}}</p>
           </div>
        @endif
        @if(!empty($tarefa->cronograma->realizado))
         <div class="form-group">
               <label class="control-label">Data Prevista para Término:</label>
                 <p class="form-static">{{diffForHumans($tarefa->cronograma->realizado)}}</p>
           </div>
        @endif
       

    </div>
		</div>
    <div class="row">
      <div class="col-md-12">
         <div class="form-group">
          <button type="button" class="btn btn-primary edit-tarefa" data-id='{{$tarefa->id}}'>Editar</button> 
          <button class="btn btn-danger tarefa-delete" data-id='{{$tarefa->id}}'>Excluir</button> 
          <a href='#' class="btn btn-github tarefa-anexos" data-id="{{$tarefa->id}}" style='position:relative;'>
            <span class="badge bg-aqua">{{$tarefa->anexos->count()}}</span>
            Anexos</a>
            <button data-dismiss="modal" aria-hidden="true" class="btn btn-warning pull-right">Sair</button>
      </div>
      </div>
    </div>
   </div>
</div>
