@extends('frontend.layouts.master')

@section('content')
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Equipes</h3>
			<div class="box-tools pull-right">
				<div class="pull-right" style='margin-bottom: 10px;'>
					<div class="btn-group">
					@permission('criar-equipes')
						<button class="btn btn-primary btn-xs" id="criarEquipe">Criar Equipe</button>
					@endauth
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="box-body">
			<table class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="equipesTable">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Observações</th>
							<th>Responsável</th>
							<th width='5%'>Membros</th>
					</thead>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
				</table>
		</div>
	</div>
@endsection

@section('scripts')

{!! Html::script('js/equipes.js') !!}

@endsection
