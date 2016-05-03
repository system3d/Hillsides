<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Trocar Icone de {{$tarefa->descricao}}</h4>
   </div>
   <div class="panel-body">
       <form id="trocar_icone" data-parsley-validate="">
       <input type="hidden" name="tarefa" value="{{$tarefa->id}}">
       	<div class="row">
       		<div class="col-md-12">
            <div class="form-group">
                   <label for="fullname" class="control-label">Icone Atual:</label>
                     <img src="{{  asset('img/icones/'.$tarefa->icone.'?'.date('s')) }}" alt="" class="img-modal">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Escolha um Icone:</label>
                    <div class="row">
                      @foreach($icones as $icone)
                        <div class="col-md-2 icons-default-choose" style='padding-bottom:10px' data-icon='{{$icone->icone}}' data-task='{{$tarefa->id}}'>
                          <img src="{{  asset('img/icones/'.$icone->icone.'?'.date('s')) }}" alt="" class="img-modal">
                        </div>
                      @endforeach
                    </div>
                </div>
       			<div class="form-group">
                   <label for="fullname" class="control-label">Ou Envie outro icone de sua preferencia:</label>
                     <input type="file" class="form-control" required="" data-parsley-trigger="change" name="icon" style='width:100%'>
                </div>

                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-sm">Gravar</button> <button data-dismiss="modal" aria-hidden="true" class="btn btn-danger btn-sm">Cancelar</button>
              </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>