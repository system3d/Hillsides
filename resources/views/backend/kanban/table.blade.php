<table class="table_kanban skin-default">
	<thead>
		<tr>
		<th id='historia-table-header'>História</th>
		<th width='{{$columnWidth}}' data-phase='Backlog'>Backlog <span class="column-hover column-collapse hidden"><i class="fa fa-minus"></i></span></th>
		@foreach($projeto->estagios as $estagio)
			<th width='{{$columnWidth}}' data-phase='{{$estagio->descricao}}'>{{$estagio->descricao}} 
			<span class="column-hover column-collapse hidden"><i class="fa fa-minus"></i></span></th>
		@endforeach
		<th width='{{$columnWidth}}' data-phase='Arquivadas'>Arquivadas <span class="column-hover column-collapse hidden"><i class="fa fa-minus"></i></span></th>
		</tr>
	</thead>
	<tbody id='kanbanBody'>
		@foreach($projeto->historias() as $historia)
			<tr id='H-{{$historia->id}}'>
				<td class='td-story'><br>{{$historia->descricao}}  <br> <div class="text-center"><button class="btn btn-sm btn-primary story-button"><i class="fa fa-search"></i></button></div> </td>
				<td class='sortable-row' data-story='{{$historia->id}}' data-phase='Backlog' data-width='{{$columnWidth}}'>
					@include('backend.kanban.tarefa')
					@include('backend.kanban.tarefa')
				</td>
				@foreach($projeto->estagios as $estagio)
					<td class='sortable-row' data-story='{{$historia->id}}' data-phase='{{$estagio->descricao}}' data-width='{{$columnWidth}}'>
						@include('backend.kanban.tarefa')
						@include('backend.kanban.tarefa')
					</td>
				@endforeach
				<td class='sortable-row' data-story='{{$historia->id}}' data-phase='Arquivadas' data-width='{{$columnWidth}}'></td>
			</tr>
		@endforeach
	</tbody>
</table>