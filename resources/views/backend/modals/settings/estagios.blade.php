<style>
.ui-sortable-helper
{
   background:#fff;  
   color: #222222; 
}
</style>
<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Estágios de {{$projeto->descricao}}</h4>
   </div>
   <div class="panel-body">
	   <div class="row">
	   		<div class="col-md-12">
	   			<div class="table-responsive">
	   			<table class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="estagiosTable">
	   				<tr class='Tableodd'>
	   					<td>Backlog</td>
	   					<td style="text-align:center"><button class="btn btn-default btn-xs"  data-toggle="tooltip" data-html="true" title='Sistema'><i class="text-muted fa fa-trash"></i></button></td>
	   				</tr>
					<tbody id="sorEstagiosBody">
						@foreach($projeto->estagios->sortBy('ordem') as $estag)
							<tr data-id='{{$estag->id}}'>
							<td>
								<span class='edit-conf-estag' data-toggle="tooltip" data-html="true" title='Editar Estágio'>{{$estag->descricao}}</span>
								<form class='edit-conf-form hidden' data-parsley-validate="">
									<input type="text" name='descricao' class="form-control input-sm" required='' value='{{$estag->descricao}}' style='width:65%;display:inline-block;margin-right: 5px;'>
									<input type="hidden" name='id' value='{{$estag->id}}'>
									<button type='submit' class="btn btn-xs btn-success"><i class="fa fa-check"></i></button>
									<button class="btn btn-xs btn-danger hide-conf-edit-estag"><i class="fa fa-times"></i></button>
								</form>
							</td>
							<td style="text-align:center">
								<a href="#" class="btn btn-danger btn-xs excluir-conf-estag" data-id='{{$estag->id}}' data-toggle="tooltip" data-html="true" title='Excluir'><i class="fa fa-trash"></i></a>
							</td>
							</tr>
						@endforeach
					</tbody>
					<tr>
	   					<td>Arquivado</td>
	   					<td style="text-align:center"><button class="btn btn-default btn-xs"  data-toggle="tooltip" data-html="true" title='Sistema'><i class="text-muted fa fa-trash"></i></button></td>
	   				</tr>
				</table>
				</div>
				<a href="#" style='margin:15px' data-id='{{$projeto->id}}' class="btn btn-primary create-conf-estag">Novo Estágio</a>
				<a href='#' id='voltar_modal' class="btn btn-warning pull-right" style='margin:15px'>Voltar</a>
	   		</div>
	   </div>
   </div>
</div>