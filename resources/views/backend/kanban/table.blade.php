<?php $estCount = $projeto->estagios->count();
	  $columnWidth = 95 / ($estCount + 2);
	  $columnWidth = $columnWidth.'%';
 ?>

<table class="table_kanban">
	<thead>
		<tr>
		<th id='historia-table-header'>História</th>
		<th width='{{$columnWidth}}'>Backlog</th>
		@foreach($projeto->estagios as $estagio)
			<th width='{{$columnWidth}}'>{{$estagio->descricao}}</th>
		@endforeach
		<th width='{{$columnWidth}}'>Arquivadas</th>
		</tr>
	</thead>
	<tbody>
		@foreach($projeto->historias() as $historia)
			<tr id='H-{{$historia->id}}'>
				<td class='td-story'><br>{{$historia->descricao}} HefyVVdedvcyecbryvrik <br> <div class="text-center"><button class="btn btn-sm btn-primary story-button"><i class="fa fa-search"></i></button></div> </td>
				<td class='sortable-row' data-story='{{$historia->id}}'>
					@include('backend.kanban.tarefa')
					@include('backend.kanban.tarefa')
				</td>
				@foreach($projeto->estagios as $estagio)
					<td class='sortable-row' data-story='{{$historia->id}}'>
						@include('backend.kanban.tarefa')
						@include('backend.kanban.tarefa')
					</td>
				@endforeach
				<td class='sortable-row' data-story='{{$historia->id}}'></td>
			</tr>
		@endforeach
	</tbody>
</table>