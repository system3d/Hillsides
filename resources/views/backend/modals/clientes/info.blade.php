<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>{{$cliente->razao}}</h4>
   </div>
   <div class="panel-body">
   <div class="row">
   		<div class="col-md-6">
           <div class="form-group">
               <label class="control-label">Razão Social:</label>
                 <p class="form-static">{{$cliente->razao}}</p>
           </div>
		@if(!empty($cliente->fantasia))
		     <div class="form-group">
               <label class="control-label">Nome Fantasia:</label>
                 <p class="form-static">{{$cliente->fantasia}}</p>
           </div>
        @endif
       @if(!empty($cliente->documento))
		     <div class="form-group">
               <label class="control-label">Documento:</label>
                 <p class="form-static">{{$cliente->documento}}</p>
           </div>
        @endif
        @if(!empty($cliente->inscricao))
		     <div class="form-group">
               <label class="control-label">Inscrição:</label>
                 <p class="form-static">{{$cliente->inscricao}}</p>
           </div>
        @endif
       @if(!empty($cliente->obs))
		     <div class="form-group">
               <label class="control-label">Observações:</label>
                 <p class="form-static">{{$cliente->obs}}</p>
           </div>
		@endif         
       <br/><br/>
		<div class="form-group">
                <button type="button" class="btn btn-primary info-edit-cliente" id="CDI{{$cliente->id}}">Editar</button> <button class="btn btn-danger cliente-delete" id="DCI{{$cliente->id}}">Excluir</button> <button data-dismiss="modal" aria-hidden="true" class="btn btn-warning">Cancelar</button>
                <input type="hidden" id="CX{{$cliente->id}}">
            </div>
		</div>
       <div class="col-md-6">
       	@if(!empty($cliente->fone))
		     <div class="form-group">
               <label class="control-label">Telefone:</label>
                 <p class="form-static">{{$cliente->fone}}</p>
           </div>
        @endif
       @if(!empty($cliente->endereco))
		     <div class="form-group">
	               <label class="control-label">Endereço:</label>
	                 <p class="form-static">{{$cliente->endereco}}</p>
	           </div>
	    @endif
        @if(!empty($cliente->cidade))
		     <div class="form-group">
               <label class="control-label">Cidade:</label>
                 <p class="form-static">{{$cliente->cidade}}</p>
           </div>
        @endif
       @if(!empty($cliente->cep))
		     <div class="form-group">
               <label class="control-label">CEP:</label>
                 <p class="form-static">{{$cliente->cep}}</p>
           </div>
         @endif
        @if(!empty($cliente->email))
		     <div class="form-group">
               <label class="control-label">E-Mail:</label>
                 <p class="form-static">{{$cliente->email}}</p>
           </div>
         @endif
        @if(!empty($cliente->site))
		     <div class="form-group">
               <label class="control-label">Site:</label>
                 <p class="form-static">{{$cliente->site}}</p>
           </div>
          @endif
        @if(!empty($cliente->responsavel))
		     <div class="form-group">
               <label class="control-label">Responsavel:</label>
                 <p class="form-static">{{$cliente->responsavel}}</p>
           </div>
        @endif
		</div>
   </div>
</div>
