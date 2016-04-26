<div class="box box-primary direct-chat box-solid collapsed-box" id='chat_users_list'>
  <div class="box-header hoverPointer" id='toggleChatList'>
    <h3 class="box-title"><i class="fa fa-comments" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatos</h3>
    <div class="box-tools pull-right">
      <i class="fa fa-plus" id='chat_is_toggle' aria-hidden="true"></i>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body no-padding bg-dark-blue" style="position: relative;overflow-y:auto; width: auto; height: 300px;">
      <ul class="chat_menu" id='chat_menu_list' style="width: 100%; height: 300px;">
      @foreach(access()->user()->locatario->users->sortBy('name') as $chat_user)
      @if($chat_user->isOnline() && $chat_user->id != access()->user()->id)
      <li class='chat_user' data-id="{{$chat_user->id}}" data-name='{{$chat_user->name}}'><!-- start message -->
          <div class="pull-left">
            <img src="{{ asset('img/avatar/'.$chat_user->avatar) }}" class="img-circle chat_list_img" alt="User Image">
          </div>
          <h4>
            {{str_limit($chat_user->name,25,'...')}}
          </h4>
          <small>
            @if($chat_user->isOnline())
            <i class="fa fa-circle text-success"></i> Online
            @else
            <i class="fa fa-circle text-danger"></i> Offline
            @endif
          </small>
      </li><!-- end message -->
      @endif
      @endforeach
      @foreach(access()->user()->locatario->users->sortBy('name') as $chat_user)
      @if(!$chat_user->isOnline() && $chat_user->id != access()->user()->id)
      <li class='chat_user' data-id="{{$chat_user->id}}" data-name='{{$chat_user->name}}'><!-- start message -->
          <div class="pull-left">
            <img src="{{ asset('img/avatar/'.$chat_user->avatar) }}" class="img-circle chat_list_img" alt="User Image">
          </div>
          <h4>
            {{str_limit($chat_user->name,25,'...')}}
          </h4>
          <small>
            @if($chat_user->isOnline())
            <i class="fa fa-circle text-success"></i> Online
            @else
            <i class="fa fa-circle text-danger"></i> Offline
            @endif
          </small>
      </li><!-- end message -->
      @endif
      @endforeach
    </ul>
  </div>
  <div class="box-footer box-footer-primary">
    <form id='chat_search'>
      <div class="input-group">
        <input type="text" name="message" id='chat_search_field' placeholder="Procurar..." class="form-control">
      </div>
    </form>
  </div><!-- /.box-footer-->
</div>