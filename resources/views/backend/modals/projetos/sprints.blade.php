<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Sprints de {{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
	   <div class="row">
	   		<div class="col-md-12">
	   			<div class="table-responsive">
	   			<table class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="modalTable">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Observações</th>
							<th>Data de Início</th>
							<th>Previsão de Término</th>
							<th>Custo Previsto</th>
							<th></th>
						</tr>
					</thead>
					@if(isset($projeto->sprints->first()->id))
						@foreach($projeto->sprints as $sprint)
							<tr>
							<td>{{$sprint->descricao}}</td>
							<td>{{$sprint->obs}}</td>
							<td>
								@if(!empty($sprint->inicio))
									{{date('d/m/Y',strtotime($sprint->inicio))}}</td>
								@else
								 - 
								@endif
							<td>
								@if(!empty($sprint->termino))
									{{date('d/m/Y',strtotime($sprint->termino))}}</td>
								@else
								 - 
								@endif
							<td>
								@if(!empty($sprint->custo))
									{{$sprint->custo}} R$
								@else
									 - 
								@endif
							</td>
							<td style="text-align:center">
								<a href="#" class="btn btn-primary btn-xs" data-id='{{$sprint->id}}' data-toggle="tooltip" data-html="true" id='editar-sprint' title='Editar'><i class="fa fa-pencil"></i></a>
								<a href="#" class="btn btn-info btn-xs" data-id='{{$sprint->id}}' data-toggle="tooltip" data-html="true" id='hist-sprint' title='Historias'><i class="fa fa-book"></i></a>
								<a href="#" class="btn btn-danger btn-xs" data-id='{{$sprint->id}}' data-toggle="tooltip" data-html="true" id='excluir-sprint' title='Excluir'><i class="fa fa-trash"></i></a>
							</td>
							</tr>
						@endforeach
					@endif
				</table>
				</div>
				<a href="#" style='margin:15px' data-proj-id='{{$projeto->id}}' class="btn btn-primary create-sprint">Novo Sprint</a>
				<a href='#' id='voltar_modal' class="btn btn-warning pull-right" style='margin:15px'>Voltar</a>
	   		</div>
	   </div>
   </div>
</div>