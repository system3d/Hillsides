<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Nova Disciplina para {{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
       <form id="disciplina_cadastro" class='modal_form' data-parsley-validate="">
	     <input type="hidden" name="tipo_cadastro" value="disciplinas">
       <input type="hidden" name="projeto_id" value="{{$projeto->id}}">
       	<div class="row">
       		<div class="col-md-12">
       			<div class="form-group">
                   <label for="fullname" class="control-label">Nome <i class="text-red">*</i> :</label>
                     <input type="text" class="form-control" required="" data-parsley-trigger="change" name="descricao" style='width:100%'>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Observações:</label>
                      <textarea id="message" rows="3" class="form-control" data-parsley-trigger="keyup" name="obs" style='width:100%'></textarea>
                </div>

                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Gravar</button>
                  <a href='#' id='voltar_modal' class="btn btn-danger voltar-table">Cancelar</a>
              </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>