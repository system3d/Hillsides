<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Disciplinas de {{$projeto->descricao}}</h4>
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
							<th>Criado</th>
							<th></th>
						</tr>
					</thead>
					@if(isset($projeto->disciplinas->first()->id))
						@foreach($projeto->disciplinas as $disciplina)
							<tr>
							<td>{{$disciplina->descricao}}</td>
							<td>{{$disciplina->obs}}</td>
							<td>{{date('d/m/Y',strtotime($disciplina->created_at))}}</td>
							<td style="text-align:center">
								<a href="#" class="btn btn-primary btn-xs" data-id='{{$disciplina->id}}' data-toggle="tooltip" data-html="true" id='editar-disciplina' title='Editar'>
									<i class="fa fa-pencil"></i>
								</a>
								<a href="#" class="btn btn-danger btn-xs" data-id='{{$disciplina->id}}' data-toggle="tooltip" data-html="true" id='excluir-disciplina' title='Excluir'>
									<i class="fa fa-trash"></i>
								</a>
							</td>
							</tr>
						@endforeach
					@endif
				</table>
				</div>
				<a href="#" style='margin:15px' data-id='{{$projeto->id}}' class="btn btn-primary criar-disciplina">Nova Disciplina</a>
				<a href='#' id='voltar_modal' class="btn btn-warning pull-right voltar-table" style='margin:15px'>Voltar</a>
	   		</div>
	   </div>
   </div>
</div>