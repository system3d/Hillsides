@if(access()->user()->locatario->users->count() > 1)
<div class="box box-primary direct-chat box-solid collapsed-box" id='chat_users_list'>
  <div class="box-header hoverPointer" id='toggleChatList' data-widget="collapse">
    <i class="fa fa-plus" aria-hidden="true" style='float:right;font-size:12px'></i>
    <h3 class="box-title"><i class="fa fa-comments" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatos </h3>
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
          <small class='chat_user_status'>
            <i class="fa fa-circle text-success"></i> Online
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
          <small class='chat_user_status'>
            @if(isset($chat_user->lastActivity->data))
            <?php $lastActivityObj =  timeDiff($chat_user->lastActivity->data);?>
              @if($lastActivityObj['t'] < 86000)
                Visto(a) por último à 
                @if($lastActivityObj['h'] > 0)
                  @if($lastActivityObj['h'] == 1)
                    {{$lastActivityObj['h']}} hora
                  @else
                    {{$lastActivityObj['h']}} horas
                  @endif
                @else
                {{$lastActivityObj['m']}} minutos
                @endif
              @else
              <i class="fa fa-circle text-danger"></i> Offline
              @endif
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
@endif

<div id="chat_windows_container">
  
</div>
