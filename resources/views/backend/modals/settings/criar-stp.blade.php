<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Novo Status para {{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
     <form class='modal_form' data-parsley-validate="">
		<input type="hidden" name="tipo_cadastro" value="status">
		<input type="hidden" name="projeto_id" value="{{$projeto->id}}">
       	<div class="row">
       		<div class="col-md-12">
       			  <div class="form-group">
                   <label for="fullname" class="control-label">Nome <i class="text-red">*</i> :</label>
                     <input type="text" class="form-control" required="" data-parsley-trigger="change" name="descricao" style='width:100%'>
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