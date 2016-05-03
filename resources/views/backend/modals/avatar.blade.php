<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Alterar Avatar</h4>
   </div>
   <div class="panel-body">
	   <div class="row">
	   		<div class="col-md-12">
	   			 <div class="form-group">
                   <label for="fullname" class="control-label">Avatar Atual:</label>
                 	<img src="{{  asset('img/avatar/'.$user->avatar.'?'.date('s')) }}" alt="" class="img-circle img-avatar-modal">
                </div>
                <form id="trocar-avatar-user" data-parsley-validate="">
	       			<div class="form-group">
                   		<label for="fullname" class="control-label">Novo Avatar:</label>
                     	<input type="file" class="form-control" required="" data-parsley-trigger="change" name="icon" style='width:100%'>
               		</div>

	                <br><br>
	                <div class="form-group">
	                 	 <button type="submit" class="btn btn-primary">Gravar</button>
	                 	 <a href='#'  data-dismiss="modal" aria-hidden="true" class="btn btn-danger">Cancelar</a>
	             	</div>
      		 	</form>
	   		</div>
	   </div>
   </div>
</div>