<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Editar Cliente</h4>
   </div>
   <div class="panel-body">
       <form id="cliente_atualizar" data-parsley-validate="">
       	<div class="row">
       		<div class="col-md-6">
       			<div class="form-group">
                   <label for="fullname" class="control-label">Razão Social <i class="text-red">*</i> :</label>
                     <input type="text" class="form-control" required="" data-parsley-trigger="change" name="razao" value="{{$cliente->razao}}">
                     <input type="hidden" name="id" value="{{$cliente->id}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Nome Fantasia:</label>
                     <input type="text" class="form-control" data-parsley-trigger="change" name="fantasia" value="{{$cliente->fantasia}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Documento:</label>
                     <input type="text" class="form-control" data-parsley-trigger="change" data-parsley-type="number" name="documento" value="{{$cliente->documento}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Inscrição:</label>
                     <input type="text" class="form-control" data-parsley-trigger="change" data-parsley-type="number" name="inscricao" value="{{$cliente->inscricao}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Observações:</label>
                      <textarea id="message" rows="3" class="form-control" name="obs" data-parsley-trigger="keyup">{{$cliente->obs}}</textarea>
                </div>
                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Atualizar</button> <button data-dismiss="modal" aria-hidden="true" class="btn btn-danger">Cancelar</button>
              </div>
       		</div>
       		<div class="col-md-6">
					<div class="form-group">
                   <label for="fullname" class="control-label">Telefone:</label>
                     <input type="text" class="form-control telefone" data-parsley-trigger="change" name="fone" value="{{$cliente->fone}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Endereço:</label>
                     <input type="text" class="form-control" data-parsley-trigger="change" name="endereco" value="{{$cliente->endereco}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Cidade:</label>
                     <input type="text" class="form-control" data-parsley-trigger="change" name="cidade" value="{{$cliente->cidade}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">CEP:</label>
                     <input type="text" class="form-control cep" data-parsley-trigger="change" name="cep" value="{{$cliente->cep}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">E-Mail:</label>
                     <input type="email" class="form-control" data-parsley-trigger="change" name="email" value="{{$cliente->email}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Site:</label>
                     <input type="text" class="form-control" data-parsley-trigger="change" name="site" value="{{$cliente->site}}">
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Responsavel:</label>
                     <input type="text" class="form-control" data-parsley-trigger="change" name="responsavel" value="{{$cliente->responsavel}}">
                </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>