<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Trocar Icone de {{$tarefa->descricao}}</h4>
   </div>
   <div class="panel-body">
       <form id="trocar_icone_proj" data-parsley-validate="">
       <input type="hidden" name="tarefa" value="{{$tarefa->id}}">
       	<div class="row">
       		<div class="col-md-12">
            <div class="form-group">
                   <label for="fullname" class="control-label">Icone Atual:</label>
                     <img src="{{  asset('img/icones/'.$tarefa->icone.'?'.date('s')) }}" alt="" class="img-circle img-modal">
                </div>
       			<div class="form-group">
                   <label for="fullname" class="control-label">Novo Icone:</label>
                     <input type="file" class="form-control" required="" data-parsley-trigger="change" name="icon" style='width:100%'>
                </div>

                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Gravar</button>
                  <a href='#' id='voltar_modal' class="btn btn-warning">Voltar</a>
              </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>