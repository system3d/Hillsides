<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Status de Tarefas Disponíveis para {{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
	   <div class="row">
	   		<div class="col-md-12">
	   			<div class="table-responsive">
	   			<table class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="modalTable">
					<tbody>
						@foreach($projeto->status_tarefa as $tarefa)
							<tr>
							<td>
								<span class='edit-conf-tarefa hoverPointer' data-toggle="tooltip" data-html="true" title='Editar Status'>{{$tarefa->descricao}}</span>
								<form class='edit-conf-tarefa-form hidden' data-parsley-validate="">
									<input type="text" name='descricao' class="form-control input-sm" required='' value='{{$tarefa->descricao}}' style='width:65%;display:inline-block;margin-right: 5px;'>
									<input type="hidden" name='id' value='{{$tarefa->id}}'>
									<button type='submit' class="btn btn-xs btn-success"><i class="fa fa-check"></i></button>
									<button class="btn btn-xs btn-danger hide-conf-edit-tarefa"><i class="fa fa-times"></i></button>
								</form>
							</td>
							<td style="text-align:center">
								<a href="#" class="btn btn-danger btn-xs excluir-conf-tarefa" data-id='{{$tarefa->id}}' data-toggle="tooltip" data-html="true" title='Excluir'><i class="fa fa-trash"></i></a>
							</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				</div>
				<a href="#" style='margin:15px' data-id='{{$projeto->id}}' class="btn btn-primary create-conf-tarefa">Novo Status de Tarefa</a>
				<a href='#' id='voltar_modal' class="btn btn-warning pull-right" style='margin:15px'>Voltar</a>
	   		</div>
	   </div>
   </div>
</div>