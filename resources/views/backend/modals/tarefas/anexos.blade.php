<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Anexos de {{$tarefa->descricao}}</h4>
   </div>
   <div class="panel-body">
	   <div class="row">
	   		<div class="col-md-12">
	   			<div class="table-responsive">
	   			<table class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="modalTable">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Tamanho</th>
							<th></th>
						</tr>
					</thead>
					@if(isset($tarefa->anexos->first()->id))
						@foreach($tarefa->anexos as $anexo)
							<tr>
							<td>&nbsp;&nbsp;&nbsp;<a href="{{url('tarefa/download/'.$anexo->id)}}" target="_blank" data-toggle="tooltip" title='Download'>{{$anexo->descricao}}</a></td>
							<td>{{formatBytes($anexo->tamanho)}}</td>
							<td style="text-align:center">
								<a href="#" class="btn btn-danger btn-xs excluir-anexo" data-id='{{$anexo->id}}' data-toggle="tooltip" data-html="true" title='Excluir'>
									<i class="fa fa-trash"></i></a>
							</td>
							</tr>
						@endforeach
					@endif
				</table>
				</div>
				@if($tarefa->anexos->count() < 5)
				<a href="#" style='margin:15px' data-id='{{$tarefa->id}}' class="btn btn-primary anexo-upload">Upload</a>
				@else
				<button style='margin:15px' class="btn btn-primary" data-toggle="tooltip" data-html="true" title='Maximo 5 Anexos por Tarefa'>Upload</button>
				@endif
				<a href='#' id='voltar_modal' class="btn btn-warning pull-right" style='margin:15px'>Voltar</a>
	   		</div>
	   </div>
   </div>
</div>