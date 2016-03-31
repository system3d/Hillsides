<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Sprints de {{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
	   <div class="row">
	   		<div class="col-md-12">
	   			<table class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="sprintsTable">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Observações</th>
							<th>Criado</th>
							<th></th>
						</tr>
					</thead>
					@if(isset($projeto->sprints->first()->id))
						@foreach($projeto->sprints as $sprint)
							<tr>
							<td>{{$sprint->descricao}}</td>
							<td>{{$sprint->obs}}</td>
							<td>{{date('d/m/Y',strtotime($sprint->created_at))}}</td>
							<td style="text-align:center">
								<a href="#" class="btn btn-primary btn-xs" data-toggle="tooltip" data-html="true" title='Editar'><i class="fa fa-pencil"></i></a>
								<a href="#" class="btn btn-info btn-xs" data-toggle="tooltip" data-html="true" title='Historias'><i class="fa fa-book"></i></a>
								<a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip" data-html="true" title='Excluir'><i class="fa fa-trash"></i></a>
							</td>
							</tr>
						@endforeach
					@endif
				</table>
				<a href="#" style='margin:15px' class="btn btn-primary">Novo Sprint</a>
				<a href='#' id='voltar_modal' class="btn btn-warning pull-right" style='margin:15px'>Voltar</a>
	   		</div>
	   </div>
   </div>
</div>