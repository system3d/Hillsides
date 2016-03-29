<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Editar Equipe</h4>
   </div>
   <div class="panel-body">
       <form id="equipe_atualizar" data-parsley-validate="">
       	<div class="row">
       		<div class="col-md-12">
       			<div class="form-group">
                   <label for="fullname" class="control-label">Nome <i class="text-red">*</i> :</label>
                     <input type="text" class="form-control" required="" data-parsley-trigger="change" name="descricao" value="{{$equipe->descricao}}">
                     <input type="hidden" name="id" value="{{$equipe->id}}">
                </div>
                 <div class="form-group">
                   <label for="fullname" class="control-label">Responsavel:</label>
                     <select class="form-control" required="" style='width:100%' name='responsavel_id'>
                       @foreach(access()->user()->locatario->users as $user)
                           <option value="{{$user->id}}" <?php if($user->id == $equipe->responsavel->id) echo 'selected'; ?>>{{$user->name}}</option>
                       @endforeach
                     </select>
                </div>
                <div class="form-group">
                   <label for="fullname" class="control-label">Observações:</label>
                      <textarea id="message" rows="3" class="form-control" name="obs" data-parsley-trigger="keyup">{{$equipe->obs}}</textarea>
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