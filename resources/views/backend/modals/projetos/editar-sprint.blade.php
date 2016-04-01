<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Editar {{$sprint->descricao}}</h4>
   </div>
   <div class="panel-body">
    <form id="sprint_editar" data-parsley-validate="">
		<input type="hidden" name="id" value="{{$sprint->id}}">
       	<div class="row">
       		<div class="col-md-12">
       			<div class="form-group">
                   <label for="fullname" class="control-label">Nome <i class="text-red">*</i> :</label>
                     <input type="text" class="form-control" required="" data-parsley-trigger="change" name="descricao" style='width:100%' value='{{$sprint->descricao}}'>
                </div>

                 <div class="form-group">
                   <label for="fullname" class="control-label">Custo Previsto(R$):</label>
                     <input type="number" class="form-control"  name="custo" style='width:100%' value='{{$sprint->custo}}'>
                </div>

                 <div class="form-group">
                   <div class="row">
                     <div class="col-md-6">
                        <label for="fullname" class="control-label">Data de Início:</label>
                        <input type="text" class="form-control datePicker"  name="inicio" style='width:100%' value='<?php if(!empty($sprint->termino)) echo date("d/m/Y", strtotime ($sprint->inicio)); ?>'>
                     </div>
                     <div class="col-md-6">
                        <label for="fullname" class="control-label">Previsão de Término:</label>
                        <input type="text" class="form-control datePicker"  name="termino" style='width:100%' value='<?php if(!empty($sprint->termino)) echo date("d/m/Y", strtotime ($sprint->termino)); ?>'>
                     </div>
                   </div>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Observações:</label>
                      <textarea id="message" rows="3" class="form-control" data-parsley-trigger="keyup" name="obs" style='width:100%'>{{$sprint->obs}}</textarea>
                </div>

                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Atualizar</button>
                  <a href='#' id='voltar_modal' class="btn btn-danger voltar-sprint">Cancelar</a>
              </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>