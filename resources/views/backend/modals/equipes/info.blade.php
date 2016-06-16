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
            <button type="button" class="btn btn-primary info-edit-equipe" id="EDI{{$equipe->id}}">Editar</button>
            <button class="btn btn-danger equipe-delete" id="DEI{{$equipe->id}}">Excluir</button>
            <a href='#'data-dismiss="modal" aria-hidden="true" class="btn btn-warning">Voltar</a>
            <input type="hidden" id="EX{{$equipe->id}}">
        </div>
	</div>
       <div class="col-md-6">
        <div class="form-group">
           <a href="#" id='equipe-novo-membro' class='btn btn-block btn-primary' style='width:70%;margin-left: 15%;'>Adicionar Membro</a>
           <div id="novo-membro-wrapper" class='hidden row'>
             @if(access()->user()->locatario->users->count() - count($membros) > 0)
            <div class="col-md-8">
            <br>
               <select name="membro" id="novo-membro" class="form-control chosen-select" data-equipe-id="{{$equipe->id}}">
                  @foreach(access()->user()->locatario->users as $user)
                    @if(!in_array($user->id, $membros))
                      <option value="{{$user->id}}">{{$user->name}}</option>
                    @endif
                  @endforeach
              </select>
            </div>
            <div class="col-md-4" style='margin-top: 8.5px;'>
              <a href="#" id='save-membro' class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
              <a href="#" id='close-membro' class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
            </div>
            @else
            <div class="col-md-8">
              <h4 class='form-static'>Nenhum Membro Disponível</h4>
            </div>
            <div class="col-md-4">
              <a href="#" id='close-membro' class="btn btn-danger btn-sm float-right" style='margin-right: 5px;margin-top: 5px;'><i class="fa fa-times"></i></a>
            </div>
            @endif
          </div>
          
       </div>
	     @if(isset($equipe->users->first()->id))
	     	<label class="control-label">Membros:</label>
    <div id="membros-wrapper">
      <div class="form-group">
          <div class="row">
            <div class="col-md-10">
              <p>{{$equipe->responsavel->name}} <br> <small>{{$equipe->responsavel->roles->first()->name}} - Responsável</small></p>
            </div>
          </div>
       </div>
	    @foreach($equipe->users as $user)
        @if($user->id != $equipe->responsavel_id)
    		<div class="form-group">
          <div class="row">
            <div class="col-md-10">
              <p>{{$user->name}} <br> <small>{{$user->roles->first()->name}}</small></p>
            </div>
            <div class="col-md-2">
              
              <a href="#" data-equipe-id="{{$equipe->id}}" data-toggle="tooltip" data-html="true" title='Remover Membro' data-id='{{$user->id}}' class="btn btn-danger btn-xs remover-membro"><i class="fa fa-trash"></i></a>
             
            </div>
          </div>
       </div>
        @endif
		@endforeach
    </div>
		@endif
		</div>
	</div>
</div>

<script>
  $(".chosen-select").chosen({
    width: "95%",
    no_results_text: "Nenhum resultado para ",
    search_contains: true,
    display_disabled_options: false,
  });
</script>
		 