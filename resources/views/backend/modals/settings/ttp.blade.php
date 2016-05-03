<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Tipos de Tarefas para {{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
	   <div class="row">
	   		<div class="col-md-12">
	   			<div class="table-responsive">
	   			<table class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="modalTable">
					<tbody>
						@foreach($projeto->tipos_tarefa as $tipoTarefa)
							<tr>
							<td>
								<span class='edit-conf-tipoTarefa hoverPointer' data-toggle="tooltip" data-html="true" title='Editar Status'>{{$tipoTarefa->descricao}}</span>
								<form class='edit-conf-tipoTarefa-form hidden' data-parsley-validate="">
									<input type="text" name='descricao' class="form-control input-sm" required='' value='{{$tipoTarefa->descricao}}' style='width:65%;display:inline-block;margin-right: 5px;'>
									<input type="hidden" name='id' value='{{$tipoTarefa->id}}'>
									<button type='submit' class="btn btn-xs btn-success"><i class="fa fa-check"></i></button>
									<button class="btn btn-xs btn-danger hide-conf-edit-tipoTarefa"><i class="fa fa-times"></i></button>
								</form>
							</td>
							<td style="text-align:center">
								 <a href="#" data-id='{{$tipoTarefa->id}}' data-toggle="tooltip" data-html="true" title='Cor de Fundo' class='fire-bckt-change'>
		                            <span id='BTCSP{{$tipoTarefa->id}}' class="back-tp-change" style='background:{{$tipoTarefa->cor}}'></span>
		                          </a> 
								 <a href="#" data-id='{{$tipoTarefa->id}}' data-toggle="tooltip" data-html="true" title='Icone' class='icon-tp-change'>
		                          <img class='img-p-icon' src="{{ asset('img/icones/'.$tipoTarefa->icone) }}?{{time()}}" id='tp-icon-{{$tipoTarefa->id}}'>
		                        </a>
								<a href="#" class="btn btn-danger btn-xs excluir-conf-tipoTarefa" data-id='{{$tipoTarefa->id}}' data-toggle="tooltip" data-html="true" title='Excluir'><i class="fa fa-trash"></i></a>
							</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				</div>
				<a href="#" style='margin:15px' data-id='{{$projeto->id}}' class="btn btn-primary create-conf-tipoTarefa">Novo Tipo de Tarefa</a>
				<a href='#' id='voltar_modal' class="btn btn-warning pull-right" style='margin:15px'>Voltar</a>
	   		</div>
	   </div>
   </div>
</div>