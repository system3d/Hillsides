<div class="box box-success direct-chat box-solid chat-window" data-id='{{$receiver->id}}'>
  <div class="box-header hoverPointer" data-widget="collapse">
    <i class="fa fa-minus chat_is_toggle" aria-hidden="true" style='display:none'></i>
    <h3 class="box-title chat-title" data-toggle='tooltip' title='{{$receiver->name}}'>
        {{str_limit($receiver->name,25,'...')}}</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool remove-window-chat"><i class="fa fa-times"></i></button>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body">
     <div class="direct-chat-messages">
    @foreach($messages as $msg)
      @if($msg->sender_id == $receiver->id)
       <div class="direct-chat-msg" data-id='{{$msg->id}}'>
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left">{{$receiver->name}}</span>
          <span class="direct-chat-timestamp pull-right">{{datePtFormat($msg->created_at)}}</span>
        </div><!-- /.direct-chat-info -->
        <div class="direct-chat-text sender-txt">
{{--            <i class="fa fa-check status-chat status-chat{{$msg->status}}" aria-hidden="true"></i> --}}
          {{$msg->message}}
           
            <br>
        </div><!-- /.direct-chat-text -->
      </div><!-- /.direct-chat-msg -->
      @else
        <div class="direct-chat-msg right" data-id='{{$msg->id}}'>
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-right">{{$sender->name}}</span>
          <span class="direct-chat-timestamp pull-left">{{datePtFormat($msg->created_at)}}</span>
        </div><!-- /.direct-chat-info -->
        <div class="direct-chat-text receiver-txt">
          <i class="fa fa-check status-chat status-chat{{$msg->status}}" aria-hidden="true"></i>
          {{$msg->message}}
            
            <br>
        </div><!-- /.direct-chat-text -->
      </div><!-- /.direct-chat-msg -->
      @endif
    @endforeach

    </div><!--/.direct-chat-messages-->

  </div><!-- /.box-body -->
  <div class="box-footer">
    <form class='send-chat-message' data-id='{{$receiver->id}}' method="post">
      <p class='help-block istiping-block visNone' data-id='{{$receiver->id}}'>{{str_limit($receiver->name,25,'')}} está digitando ...</p>
      <div class="input-group"> 
        <textarea class="form-control chat-text-area" placeholder='Digite Aqui ...' data-id='{{$receiver->id}}' ></textarea>
        <input type="hidden" name="receiver" class='receiver_id_input' value='{{$receiver->id}}'>
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success btn-flat btn-rounded"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
        </span>
      </div>
    </form>
  </div><!-- /.box-footer-->
</div>