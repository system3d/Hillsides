<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Editar {{$etapa->descricao}}</h4>
   </div>
   <div class="panel-body">
       <form id="editar_etapa" data-parsley-validate="">
       <input type="hidden" name="id" value="{{$etapa->id}}">
       	<div class="row">
       		<div class="col-md-12">
       			<div class="form-group">
                   <label for="fullname" class="control-label">Nome <i class="text-red">*</i> :</label>
                     <input type="text" class="form-control" required="" data-parsley-trigger="change" name="descricao" style='width:100%' value='{{$etapa->descricao}}'>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Observações:</label>
                      <textarea id="message" rows="3" class="form-control" data-parsley-trigger="keyup" name="obs" style='width:100%'>{{$etapa->obs}}</textarea>
                </div>

                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Atualizar</button>
                  <a href='#' id='voltar_modal' class="btn btn-danger voltar-table">Cancelar</a>
              </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>