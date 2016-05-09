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
			           <label class='pull-right label bg-green' ng-show='user.unreads > 0'>[[user.unreads]]</label>
			          </small>
			      </li><!-- end message -->
		        </ul>
			</div>
			<div class="col-md-10 msg-messages-content-wrapper">
				<div class="msg-messages-content message-overflow" ng-scroll>
					<ul>
						<li class='list-loader' ng-show='loading'><i class="fa fa-refresh fa-spin" aria-hidden="true"></i></li>
						<li class='end-talk' ng-show='endTalk'><i>Fim da Conversa.</i></li>
						<ul ng-repeat="(key, value) in messages | orderBy : sortMsgs| groupBy: 'day' ">
							<li class='day-marker'><span>[[key | formatDate]]</span></li>
							<li ng-repeat='msg in value | orderBy : sortMsgs' ng-class="{msgSender: thisUserId == msg.sender_id}" class='msg-content-box'>
								 <div class="pull-left">
					            <img ng-src="img/avatar/[[users[msg.sender_id].avatar]]" class="img-circle chat_list_img" alt="User Image">
					          </div>
					          <h4>
					            [[users[msg.sender_id].name]]
					            <small class="chat_user_status">
					            	<i class="fa fa-paper-plane-o" aria-hidden="true"></i>&nbsp;&nbsp;[[msg.created_at | date_br]]
					            </small>
					          </h4>
					          <p>
					          	[[msg.message]]
					          </p>
							</li>
						</ul>
					</ul>
				</div>
				<div class="textarea-wrapper">
					<span>&nbsp;<small  ng-show='isTyping'>[[users[activeUser].name]] está digitando ...</small></span>
					<form ng-submit='sendMessage()' name='messageForm'>
						<textarea name="message" ng-keydown='setIsTyping($event)' ng-model="messageContent" ng-enter="sendMessage()" class='form-control' placeholder='Digite Aqui...' required></textarea>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	
@endsection

@section('scripts')
	{!! Html::script('js/messages/document.js') !!}
	{!! Html::script('plugins/angular/angular.min.js') !!}
	{!! Html::script('plugins/angular/angular-filter.min.js') !!}
	{!! Html::script('js/messages/app.js') !!}
@endsection
