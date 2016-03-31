<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Equipes de {{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
   <div class="row">
   		<div class="col-md-6">
       @if(isset($projeto->equipes->first()->id))

          @foreach($projeto->equipes as $peq)
            <div class="form-group" style='margin-right: 80px;'>
              <a href="#" class="pull-right btn-xs btn-google remove-equipe-proj" data-id='{{$peq->id}}' data-projeto-id='{{$projeto->id}}' data-toggle="tooltip" data-html="true" title='Remover Equipe'>
                <i class="fa fa-trash"></i></a>
               <label class="control-label"><a href="#" data-id='{{$peq->id}}' class='ver-equipe'>{{$peq->descricao}}</a></label>
                <p class="form-static">Membros:  <br>
                  <small>
                  <strong data-toggle="tooltip" data-html="true" title='Responsavel'>{{$peq->responsavel->name}}</strong> - {{$peq->responsavel->roles()->first()->name}}
                  @foreach($peq->users as $meq)
                    
                    @if($meq->id != $peq->responsavel_id) 
                    <br> {{$meq->name}} - {{$meq->roles()->first()->name}}
                   @endif
                  @endforeach
                  </small>
                </p>
                <hr>
           </div>
         
          @endforeach
       @else
          <h4 style='margin-bottom:15px;text-align: center;'>Nenhuma Equipe Vinculada</h4>
       @endif
      <div class="form-group">
            <a href='#' id='voltar_modal' class="btn btn-warning">Voltar</a>
      </div>
	</div>
       <div class="col-md-6">
        
       <label class="control-label">Adicionar Equipe:</label>
       <div id="nova-equipe-wrapper" style='margin-top: 5px;' class='row'>
             @if($equipes->count() > 0)
            <div class="col-md-8">
               <select name="equipe" id="nova-equipe" class="form-control" data-projeto-id="{{$projeto->id}}">
                  @foreach($equipes as $equipe)
                      <option value="{{$equipe->id}}">{{$equipe->descricao}}</option>
                  @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <a href="#" id='save-equipe' class="btn btn-success btn-sm" data-toggle="tooltip" data-html="true" title='Adicionar Equipe'><i class="fa fa-check"></i></a>
              <a href="#" id='ver-equipe-select' class="btn btn-info btn-sm" data-toggle="tooltip" data-html="true" title='Exibir Equipe'><i class="fa fa-eye"></i></a>
            </div>
            @else
            <div class="col-md-8">
              <h4 class='form-static'>Nenhuma Equipe Disponível</h4>
            </div>
            @endif
          </div>
          <hr>
          <div id="info-equi-container"></div>
      
		</div>

	</div>
</div>
		 