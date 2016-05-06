@extends('frontend.layouts.master')

@section('styles')

{{Html::style('css/mensagens.css')}}

@endsection

@section('content')

<div class="box box-success" ng-app="ChatApp" ng-controller="ChatCtrl" ng-init="initChat()">
	<div class="box-header with-border msg-box-header">
		<h3 class="box-title">Mensagens</h3>
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
		<div class="row msg-row">
			<div class="col-md-2 msg-users-content">
				[[users]]
			</div>
			<div class="col-md-10 msg-messages-content">
				[[messages]]
			</div>
		</div>
	</div>
</div>
	
@endsection

@section('scripts')
	{!! Html::script('plugins/angular/angular.min.js') !!}
	{!! Html::script('plugins/angular/angular-route.min.js') !!}
	{!! Html::script('js/messages/app.js') !!}
@endsection
