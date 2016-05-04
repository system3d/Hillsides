$(document).ready(function() {
	 var canal = 'message-'+thisUserId;
   var canalStatus = 'chat-misc-status-'+thisLocatarioId;
   var canalStatusOffline = 'chat-misc-status-offline-'+thisLocatarioId;
   var canalTyp = 'typing-'+thisUserId;
   var canalRec = 'chat-misc-read-'+thisUserId;
  if(app_env == 'local')
    var socket = io(':3000');
  else
    var socket = io('http://steel4web.com.br:3000');

     socket.on(canal, function(data) {
       var dados = data.data.data.message;
       appendRealMessage(dados);
    });

      socket.on(canalTyp, function(data) {
       var rec = data.receiver;
       setTyping(rec);
    });

     socket.on(canalRec, function(data) {
       var rec = data.data.data.message.params;
       setRead(rec);
    });

    socket.on(canalStatus, function(data) { 
        var id = data.data.data.message.params;
        changeToOnline(id);
        $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').attr('data-time', 1);
        $('.chat_user[data-id="'+id+'"]').attr('data-off', 'false');
    });

    socket.on(canalStatusOffline, function(data) {
       var id = data.data.data.message.params;
       $('.chat_user[data-id="'+id+'"]').attr('data-off', 'true');
       changeToTime(id);
    });

     $(document).on('keydown', '.chat-text-area', function(event) {
      var rec = $(this).attr('data-id');
        if(event.which == 13) {
              event.preventDefault();
              var text = $(this);
        var msg = text.val();
        
        if(msg != ''){
          $.ajax({
            url: urlbaseGeral + '/chat/send',
            type: 'POST',
            dataType: 'json',
            data: {msg: msg,receiver:rec},
          })
          .done(function(r) {
            if(r.status == 0 || r.status == 3){
              insertMsg(r.id,r.msg,r.name,r.time,r.status,r.receiver,0);
              text.val('');
            }
          });
        }
        }else{
         socket.emit("typing", {sender: thisUserId,receiver:rec});
        }
    });

   $(document).on('click', '.chat-user-header', function(event) {
    event.preventDefault();
    createChatWindow(thisUserId,$(this).attr('data-id'));
  });

});


setInterval(function(){ 
  autoUpdateStatus();
}, 60000);


function appendRealMessage(dados){
  if(!$('.chat-window[data-id="'+dados.sender+'"]').length){
     if($('.chat-user-header[data-id="'+dados.sender+'"]').length){
        var $element =  $('.chat-user-header[data-id="'+dados.sender+'"]');
        var count = parseInt($element.find('.count-unread').html());
        count = !isNaN(count) ? (count + 1) : 1;
        $element.remove();
     }else{
      var count = 1;
     }
     addMessageHeader(dados,count);
     var total = parseInt($('#msgsTotalHeader').html());
      total = total + 1;
      $('#msgsTotalHeader').html(total);
      $('#msgsTotalHeader').removeClass('hidden');
      if(config.chat_sounds != '0'){
        var snd = new Audio(urlbaseGeral + "/sounds/beep.wav");
        snd.play();
      }
  }else{
    var header = dados.header;
    markAsRead(dados.sender);
    var $element =  $('.chat-user-header[data-id="'+dados.sender+'"]');
    $element.find('p').html(dados.message.substring(0,30));
    $element.find('h4').find('small').html('<i class="fa fa-clock-o"></i> '+header.date);
    insertMsg(header.id,dados.message,header.name,header.date,header.status,dados.sender,1);
    if(config.chat_sounds != '0'){
        var snd2 = new Audio(urlbaseGeral + "/sounds/pop.wav");
        snd2.play();
      }
       $('.chat-window[data-id="'+dados.sender+'"]').removeClass('collapsed-box');
       $('.chat-window[data-id="'+dados.sender+'"]').find('.box-body').css('display', 'block');
       $('.chat-window[data-id="'+dados.sender+'"]').find('.box-footer').css('display', 'block');
       var thisWindow = $('.chat-window[data-id="'+dados.sender+'"]').find('.direct-chat-messages');
       thisWindow.scrollTop(thisWindow.prop('scrollHeight'));
       $('.istiping-block[data-id="'+dados.sender+'"]').addClass("visNone");
  }  
}

var typing = false; 
function setTyping(rec){
  if($('.chat-window[data-id="'+rec+'"]').length){
    if(!typing){
       $('.istiping-block[data-id="'+rec+'"]').removeClass('visNone');
       setTimeout(function(){
        typing = false;
      }, 3000);
       typing = true;
    }

    setTimeout(function(){
       if(!typing){
        $('.istiping-block[data-id="'+rec+'"]').addClass("visNone");
      }
      }, 3000);
    
 }
}

function changeToOnline(id){
  var statusHtml = $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').html('<i class="fa fa-circle text-success"></i> Online');
  var thisUser = $('.chat_user[data-id="'+id+'"]');
  var userHTML = thisUser.html();
  thisUser.remove();
  $('#chat_menu_list').prepend(thisUser);
}

function changeToOffline(id){
  var statusHtml = $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').html('<i class="fa fa-circle text-danger"></i> Offline');
  var thisUser = $('.chat_user[data-id="'+id+'"]');
  var userHTML = thisUser.html();
  thisUser.remove();
  $('#chat_menu_list').append(thisUser);
}

function changeToTime(id){
  var st_time = $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').attr('data-time');
  var timeHtml = getTimeHtml(st_time);
  $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').html(timeHtml);
  var thisUser = $('.chat_user[data-id="'+id+'"]');
  var userHTML = thisUser.html();
  thisUser.remove();
  $('#chat_menu_list').append(thisUser);
}

function changeToFive(id){
  var statusHtml = $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').html('Visto(a) por último à 5 minutos');
   var thisUser = $('.chat_user[data-id="'+id+'"]');
  var userHTML = thisUser.html();
  thisUser.remove();
  $('#chat_menu_list').append(thisUser);
}

function autoUpdateStatus(){
  var users = $('#chat_menu_list').find('.chat_user');
  users.each(function(index, el) {
    var statusTag = $(el).find('.chat_user_status');
    var id = $(el).attr('data-id');
    var isOff = $(el).attr('data-off');
    var st_time = statusTag.attr('data-time');
    if(st_time > 0){
       var new_time = parseInt(st_time) + 60;
    statusTag.attr('data-time', new_time);
    if(new_time > 86400 && st_time < 86400){
      changeToOffline(id);
    }
    if(new_time > 300 && new_time < 86400  || isOff == 'true'){
       var timeHtml = getTimeHtml(new_time);
       statusTag.html(timeHtml);
    }
   
    }
  });
}

function getTimeHtml(s){
  var obj = secondsToTime(s);
  var response = s;
  if(obj.h > 0){
    if(obj.h == 1)
      response = 'Visto(a) por último à 1 hora';
    else
      response = 'Visto(a) por último à '+obj.h+' horas';
  }else if(obj.m > 0){
    if(obj.m == 1)
      response = 'Visto(a) por último à 1 minuto';
    else
      response = 'Visto(a) por último à '+obj.m+' minutos';
  }else if(obj.s > 0){
      response = 'Visto(a) por último à 1 minuto';
  }else{
    response = '<i class="fa fa-circle text-danger"></i> Offline';
  }
  return response;
}


function markAsRead(id){
  var id = id;
  $.ajax({
    url: urlbaseGeral + '/chat/read',
    type: 'POST',
    dataType: 'json',
    data: {id: id},
  })
  .done(function( r ) {
    if(r.do == 1){
      var $element =  $('.chat-user-header[data-id="'+id+'"]');
      $element.removeClass('chat-msg-header-0').addClass('chat-msg-header-1');
      var count = parseInt($element.find('.count-unread').html());
      var total = parseInt($('#msgsTotalHeader').html());
      count = !isNaN(count) ? count : 0;
      total = total - count;
      $('#msgsTotalHeader').html(total);
      if(total > 0)
        $('#msgsTotalHeader').removeClass('hidden');
      else
        $('#msgsTotalHeader').addClass('hidden');
      $element.find('.count-unread').remove();
      if(!$element.find('p').find('.fa-check').length)
        $element.find('p').append('<i class="fa fa-check text-success pull-right"></i>');
    }
  });
  
}

function setRead(id){
  var chatWindow = $('.chat-window[data-id="'+id+'"]');
  var msgs = chatWindow.find('.right');
  msgs.each(function(index, el) {
    $(el).find('.status-chat').removeClass('status-chat0').addClass('status-chat1');
  });
}

function addMessageHeader(dados,count){
  var liHtml = '<li>';
  liHtml +=    '  <a href="#" class="chat-user-header chat-msg-header-0" data-id="'+dados.sender+'">';
  liHtml +=    '    <div class="pull-left">';
  liHtml +=    '         <img src="'+urlbaseGeral+'/img/avatar/'+dados.header.avatar+'" class="img-circle" alt="User Image">';
  liHtml +=    '    </div>';
  liHtml +=    '    <h4>';
  liHtml +=            dados.header.name.substring(0,20);
  liHtml +=    '      <small><i class="fa fa-clock-o"></i> '+dados.header.date+'</small>';
  liHtml +=    '   </h4>';
  liHtml +=    '   <p>'+dados.message.substring(0,30);
  liHtml +=    '      <span class="label label-info count-unread" data-id="'+dados.sender+'">'+count+'</small>';
  liHtml +=    '   </p>';
  liHtml +=    '  </a>';
  liHtml +=    '</li>';
  $('#ulHeaderMenuChat').prepend(liHtml);
}
