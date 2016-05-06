@extends('frontend.layouts.master')

@section('styles')

{{Html::style('css/mensagens.css')}}

@endsection

@section('content')

<div class="box box-primary" id='messages-box-wrapper' ng-app="ChatApp" ng-controller="ChatCtrl" ng-init="initChat()" ng-cloak>
	<div class="box-body">
		<div class="row msg-row">
			<div class="col-md-2 msg-users-content message-overflow">
				<input type="text" class="form-control input-chat-search" placeholder='Procurar...' ng-model="userSearch">
				<ul>
				 <li ng-repeat='user in users | filter:{name: userSearch,id: "!"+thisUserId} | orderBy : sortUsers : true' ng-class="{active: activeUser==user.id}" ng-click='changeActiveUser([[user.id]])'><!-- start message -->
			          <div class="pull-left">
			            <img ng-src="img/avatar/[[user.avatar]]" class="img-circle chat_list_img" alt="User Image">
			          </div>
			          <h4>
			            [[user.name | limitTo : 20 : 0]][[user.name.length > 20 ? '...' : '']]
			          </h4>
			          <small class='chat_user_status'>
			           <i class="fa fa-paper-plane-o" aria-hidden="true"></i>&nbsp;&nbsp;[[user.last.date | date_br]]
			          </small>
			      </li><!-- end message -->
		        </ul>
			</div>
			<div class="col-md-10 msg-messages-content message-overflow">
				<ul>
					<li ng-repeat='msg in messages | orderBy : created_at'>
						 <div class="pull-left">
			            <img ng-src="img/avatar/[[users[msg.sender_id].avatar]]" class="img-circle chat_list_img" alt="User Image">
			          </div>
			          <h4>
			            [[users[msg.sender_id].name | limitTo : 20 : 0]][[user.name.length > 20 ? '...' : '']]&nbsp;&nbsp;&nbsp;&nbsp;[[msg.created_at | date_br]]<br>
			            [[msg.message]]
			          </h4>
					</li>

				</ul>
			</div>
		</div>
	</div>
</div>
	
@endsection

@section('scripts')
	{!! Html::script('js/messages/document.js') !!}
	{!! Html::script('plugins/angular/angular.min.js') !!}
	{!! Html::script('js/messages/app.js') !!}
@endsection
