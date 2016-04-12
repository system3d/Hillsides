<input type="hidden" id='projeto_id_kanban' value='{{$projeto->id}}'>
<table class="table_kanban skin-default">
	<thead>
		<tr>
		<th id='historia-table-header' data-column='1'>História</th>
		<th width='{{$columnWidth}}' data-phase='Backlog' data-column='2' class='backlog resizableColumn'>Backlog <span class="column-hover column-collapse hidden"><i class="fa fa-minus"></i></span></th>
		<?php $data_column = 3; ?>
		@foreach($projeto->estagios->sortBy('ordem') as $estagio)
			<th width='{{$columnWidth}}' data-column='{{$data_column}}' data-phase='{{$estagio->descricao}}' data-estagio='{{$estagio->id}}' class='resizableColumn'>{{$estagio->descricao}} 
			<span class="column-hover column-collapse hidden"><i class="fa fa-minus"></i></span></th>
			<?php $data_column++; ?>
		@endforeach
		<th width='{{$columnWidth}}' data-column='{{$data_column}}' class='arquivo resizableColumn' data-phase='Arquivadas'>Arquivadas <span class="column-hover column-collapse hidden"><i class="fa fa-minus"></i></span></th>
		</tr>
	</thead>
	<tbody id='kanbanBody'>
		@foreach($projeto->historias() as $historia)
			<tr id='H-{{$historia->id}}' class='kanban-trow' data-story='{{$historia->id}}' data-sprint='{{$historia->sprint_id}}'>
				<td class='td-story' data-column='1'><span style='padding-top: 3px;'>História:</span><br>{{$historia->descricao}} <br> <br> Sprint: <br> {{$historia->sprint->descricao}} <br> </td>
				<td class='sortable-row backlog' data-column='2' data-story='{{$historia->id}}' data-estagio='1' data-phase='Backlog' data-width='{{$columnWidth}}'>

				</td>
				<?php $data_column = 3; ?>
				@foreach($projeto->estagios->sortBy('ordem') as $estagio)
					<td class='sortable-row' data-column='{{$data_column}}' data-story='{{$historia->id}}' data-phase='{{$estagio->descricao}}' data-estagio='{{$estagio->id}}' data-width='{{$columnWidth}}'>
					</td>
					<?php $data_column++; ?>
				@endforeach
				<td class='sortable-row arquivo' data-column='{{$data_column}}' data-story='{{$historia->id}}' data-estagio='2' data-phase='Arquivadas' data-width='{{$columnWidth}}'></td>
			</tr>
		@endforeach
	</tbody>
	 <div class="overlay dark loader hidden" id='kanban_loader'>
             <i class="fa loading"></i>
        </div>
</table>
@if(!isset($projeto->historias()->first()->id))
	  <div class="alert alert-info">
	   <div class="alert-heading" style='color:white;background:#00c0ef'>
	    <h4><i class="icon fa fa-warning"></i> Nenhuma História Cadastrada!</h4>
	    <a href="#" class='criar-historia' data-tipo='projeto' data-id='{{$projeto->id}}'>Cadastre uma História</a> Para Continuar.
	  </div>
	</div>
@endif