<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Editar Projeto</h4>
   </div>
   <div class="panel-body">
       <form id="projeto_atualizar" data-parsley-validate="">
       	<div class="row">
       		<div class="col-md-12">
       			<div class="form-group">
                   <label for="fullname" class="control-label">Nome <i class="text-red">*</i> :</label>
                     <input type="text" class="form-control" required="" data-parsley-trigger="change" name="descricao" style='width:100%' value="{{$projeto->descricao}}">
                     <input type="hidden" name="id" value="{{$projeto->id}}">
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Descrição:</label>
                      <textarea id="message" rows="3" class="form-control" data-parsley-trigger="keyup" name="obs" style='width:100%'>{{$projeto->obs}}</textarea>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Tipo:</label>
                     <select class="form-control" required="" style='width:100%' name='tipo_id'>
                       @foreach($tipos as $tipo)
                        <option value="{{$tipo->id}}" <?php if($tipo->id == $projeto->tipo_id) echo 'selected'; ?>>{{$tipo->descricao}}</option>
                       @endforeach
                     </select>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Status:</label>
                     <select class="form-control" required="" style='width:100%' name='status_id'>
                       @foreach($projeto->statuses as $spd)
                        <option value="{{$spd->id}}" <?php if($spd->id == $projeto->status_id) echo 'selected'; ?>>{{$spd->descricao}}</option>
                       @endforeach
                     </select>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Cliente:</label>
                     <select class="form-control" required="" style='width:100%' name='cliente_id'>
                       @foreach(access()->user()->locatario->clientes as $cliente)
                        <option value="{{$cliente->id}}" <?php if($cliente->id == $projeto->cliente_id) echo 'selected'; ?>>{{$cliente->razao}}</option>
                       @endforeach
                     </select>
                </div>
                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Atualizar</button>
                  <a href='#' id='voltar_modal' class="btn btn-danger">Cancelar</a>
              </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>