@extends('frontend.layouts.master')

@section('content')
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Clientes</h3>
			<div class="box-tools pull-right">
				<div class="pull-right" style='margin-bottom: 10px;'>
					<div class="btn-group">
						<button class="btn btn-primary btn-xs" id="cadastrarCliente">Cadastrar Cliente</button>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="box-body">
			<table class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%" id="clientesTable">
					<thead>
						<tr>
							<th>Razão Social</th>
							<th>Nome Fantasia</th>
							<th>Telefone</th>
							<th>Cidade</th>
							<th>Endereço</th>
					</thead>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
				</table>
		</div>
	</div>
@endsection

@section('scripts')

{!! Html::script('js/clientes.js') !!}

@endsection
