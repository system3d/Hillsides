<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Adicionar Anexo em {{$tarefa->descricao}}</h4>
   </div>
   <div class="panel-body">
       <form id="upload_anexo" data-parsley-validate="">
       <input type="hidden" name="tarefa" value="{{$tarefa->id}}">
       	<div class="row">
       		<div class="col-md-12">
       			<div class="form-group">
                   <label for="fullname" class="control-label">Arquivo:</label>
                     <input type="file" class="form-control" required="" data-parsley-trigger="change" name="anexo" style='width:100%'>
                </div>

                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-sm">Gravar</button> <button id='voltar_modal' class="btn btn-danger btn-sm voltar-table">Cancelar</button>
              </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>