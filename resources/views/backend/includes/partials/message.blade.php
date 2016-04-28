<div class="box box-success direct-chat box-solid chat-window" data-id='{{$receiver->id}}'>
  <div class="box-header hoverPointer" data-widget="collapse">
    <i class="fa fa-minus" id='chat_is_toggle' aria-hidden="true" style='float:right;margin-right: 25px;font-size:12px;margin-top: 5px;'></i>
    <h3 class="box-title" data-toggle='tooltip' title='{{$receiver->name}}'>{{str_limit($receiver->name,25,'...')}}</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool remove-window-chat"><i class="fa fa-times"></i></button>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body">
    <!-- Conversations are loaded here -->
    <div class="direct-chat-messages">
      <!-- Message. Default to the left -->
      <div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left">Alexander Pierce</span>
          <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
        </div><!-- /.direct-chat-info -->
        <img src="{{ asset('img/avatar/'.$receiver->avatar) }}" class="direct-chat-img" alt="User Image">
        <div class="direct-chat-text">
          Is this template really for free? That's unbelievable!
        </div><!-- /.direct-chat-text -->
      </div><!-- /.direct-chat-msg -->

      <!-- Message to the right -->
      <div class="direct-chat-msg right">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-right">Sarah Bullock</span>
          <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
        </div><!-- /.direct-chat-info -->
        <img src="{{ asset('img/avatar/'.$sender->avatar) }}" class="direct-chat-img" alt="User Image">
        <div class="direct-chat-text">
          You better believe it!
        </div><!-- /.direct-chat-text -->
      </div><!-- /.direct-chat-msg -->
    </div><!--/.direct-chat-messages-->

  </div><!-- /.box-body -->
  <div class="box-footer">
    <form action="#" method="post">
      <div class="input-group">
        <input type="text" name="message" placeholder="Type Message ..." class="form-control">
        <input type="hidden" name="receiver" class='receiver_id_input' value='{{$receiver->id}}'>
        <span class="input-group-btn">
          <button type="button" class="btn btn-success btn-flat">Send</button>
        </span>
      </div>
    </form>
  </div><!-- /.box-footer-->
</div>