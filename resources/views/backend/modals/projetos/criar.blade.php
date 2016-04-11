<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Novo Projeto</h4>
   </div>
   <div class="panel-body">
        
       <form id="projeto_cadastro" data-parsley-validate="">

       	<div class="row">
       		<div class="col-md-12">
       			<div class="form-group">
                   <label for="fullname" class="control-label">Nome <i class="text-red">*</i> :</label>
                     <input type="text" class="form-control" required="" data-parsley-trigger="change" name="descricao" style='width:100%'>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Descrição:</label>
                      <textarea id="message" rows="3" class="form-control" data-parsley-trigger="keyup" name="obs" style='width:100%'></textarea>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Tipo:</label>
                     <select class="form-control" required="" style='width:100%' name='tipo_id'>
                       @foreach($tipos as $tipo)
                        <option value="{{$tipo->id}}">{{$tipo->descricao}}</option>
                       @endforeach
                     </select>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Status:</label>
                     <select class="form-control" required="" style='width:100%' name='status_id'>
                        <option value="0">Ativo</option>
                       @foreach(access()->user()->locatario->status_projeto_default as $spd)
                        <option value="{{$spd->id}}">{{$spd->descricao}}</option>
                       @endforeach
                     </select>
                </div>

                <div class="form-group">
                   <label for="fullname" class="control-label">Cliente:</label>
                     <select class="form-control" required="" style='width:100%' name='cliente_id'>
                       @foreach(access()->user()->locatario->clientes as $cliente)
                        <option value="{{$cliente->id}}">{{$cliente->razao}}</option>
                       @endforeach
                     </select>
                </div>

                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Gravar</button>
                  <a href='#' data-dismiss="modal" aria-hidden="true" class="btn btn-danger">Cancelar</a>
              </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>