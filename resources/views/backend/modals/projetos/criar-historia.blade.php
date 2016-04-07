@if(isset($projeto->sprints->first()->id))
<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Nova Historia para {{$obj->descricao}}</h4>
   </div>
   <div class="panel-body">
       <form id="historia_cadastro" class='modal_form' data-parsley-validate="">
	     <input type="hidden" name="tipo_cadastro" value="historias">
       <input type="hidden" name="tipo" value="{{$tipo}}">
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

                @if($tipo == 'sprint')
                <div class="form-group">
                     <label for="fullname" class="control-label">Sprint:</label>
                     <input type="hidden"  name="sprint_id" value='{{$obj->id}}'>
                     <p class="form-static" style='font-size:16px;margin-left: 7.5px;'>{{$obj->descricao}}</p>
                </div>
                @else
                  <div class="form-group">
                   <label for="fullname" class="control-label">Sprint:</label>
                     <select class="form-control" required="" style='width:100%' name='sprint_id'>
                       @foreach($obj->sprints as $sprint)
                        <option value="{{$sprint->id}}">{{$sprint->descricao}}</option>
                       @endforeach
                     </select>
                </div>
                @endif

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
@else
  <div class="alert alert-info">
   <div class="alert-heading" style='color:white;background:#00c0ef'>
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-warning"></i> Nenhum Sprint Cadastrada!</h4>
    <a href="#" class='create-sprint' data-proj-id='{{$projeto->id}}'>Cadastre um Sprint</a> em {{$projeto->descricao}} para criar Histórias.
  </div>
</div>
@endif