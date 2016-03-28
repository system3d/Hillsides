<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>{{$equipe->descricao}}</h4>
   </div>
   <div class="panel-body">
   <div class="row">
   		<div class="col-md-6">
           <div class="form-group">
               <label class="control-label">Nome:</label>
                 <p class="form-static">{{$equipe->descricao}}</p>
           </div>
       @if(!empty($equipe->responsavel_id))
		<div class="form-group">
           <label class="control-label">Responsavel:</label>
             <p class="form-static">{{$equipe->responsavel->name}}</p>
       </div>
       @endif
		@if(!empty($equipe->obs))
		<div class="form-group">
           <label class="control-label">Observações:</label>
             <p class="form-static">{{$equipe->obs}}</p>
       </div>
	@endif
      <br/><br/>
	<div class="form-group">
            <button type="button" class="btn btn-primary info-edit-equipe" id="EDI{{$equipe->id}}">Editar</button> <button class="btn btn-danger equipe-delete" id="DEI{{$equipe->id}}">Excluir</button> <button data-dismiss="modal" aria-hidden="true" class="btn btn-warning">Cancelar</button>
            <input type="hidden" id="EX{{$equipe->id}}">
        </div>
	</div>
       <div class="col-md-6">
	     @if(isset($equipe->users->first()->id))
	     	<label class="control-label">Membros:</label>
	    @foreach($equipe->users as $user)
		<div class="form-group">
           <p class="form-static">{{$user->name}} - {{$user->roles->first()->name}}</p>
       </div>
		@endforeach
		@endif
		</div>
	</div>
</div>
		 