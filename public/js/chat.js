$(document).ready(function($) {
	// $('#toggleChatList').click(function(event) {
	// 	if($(this).parent('#chat_users_list').hasClass('collapsed-box'))
	// 		updateChatStatus();
	// });
	var windWidth = $(window).height();
	var maxContatosHeight = windWidth - 200;
	maxContatosHeight = (maxContatosHeight > 500) ? maxContatosHeight : 500;
	$('#chat_menu_list').css('max-height', maxContatosHeight );

	$('#controlSidebarIcon').click(function(event) {
		organizeWindows();
	});

	$(document).on('keyup', '#chat_search_field', function(event) {
		var search = $(this).val();
		search = search.toLowerCase();
		var users = $('#chat_menu_list').find('.chat_user');
		if(search != ''){
			users.each(function(index, el){
				var attrs = $(el).attr('data-name');
				if (attrs.includes(search)){
		          $(el).removeClass('hidden');
		         }else{
		          $(el).addClass('hidden');
		         }
			});
		}else{
			users.each(function(index, el) {
		        $(el).removeClass('hidden');
		      });
		}
	});

	$('#chat_search').submit(function(event) {
		event.preventDefault();
	});

	$(document).on('click', '.remove-window-chat', function(event) {
		event.preventDefault();
		var wind = $(this).closest('.chat-window');
		wind.remove();
		organizeWindows();
	});

	$(document).on('click', '.chat_user', function(event) {
		event.preventDefault();
		var sender = thisUserId;
		var receiver = $(this).attr('data-id');
		createChatWindow(sender,receiver);
	});

	$( window ).resize(function() {
		capWindows();
	});

	$(document).on('submit', '.send-chat-message', function(event) {
		event.preventDefault();
		var text = $(this).find('.chat-text-area');
		var msg = text.val();
		var rec = $(this).attr('data-id');
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
	});

	


});

function updateChatStatus(){
	$.ajax({
         url: urlbaseGeral+"/chat/updateStatus",
         type: 'POST',
         dataType: 'html',
         data: {all: 'true'}
        }).done(function(response) {
		  	UpdateChatListStatus(response);
	 	});
}

function UpdateChatListStatus(rr){
	var status = jQuery.parseJSON(rr);
	$.each(status, function(key, r) {
	    if(r.status == 1){
	    	if($('.chat_user[data-id="'+r.user+'"]').length){
	    		var li_item = $('.chat_user[data-id="'+r.user+'"]');
	    		li_item.find('.chat_user_status').html(r.html);
	    		li_new = li_item;
	    		li_item.remove();
	    		$('#chat_menu_list').prepend(li_new);
	    	}
	    }else{
	    	if($('.chat_user[data-id="'+r.user+'"]').length){
	    		var li_item = $('.chat_user[data-id="'+r.user+'"]');
	    		li_item.find('.chat_user_status').html(r.html);
	    	}
	    }
	});
}

function createChatWindow(sender,receiver){
	var rec = receiver;
	$.ajax({
         url: urlbaseGeral+"/chat/window",
         type: 'POST',
         dataType: 'html',
         data: {sender: sender, receiver:receiver},
        }).done(function(response, receiver) {
		  	chatWindowCreator(response,rec);
		  	markAsRead(rec);
	 	});
}

function chatWindowCreator(r,receiver){
	var count = $('.chat-window').length;
	var x = 0;
	var there = [];
	var calcSizes = false;
	$('.chat-window').each(function(index, el) {
		there.push(parseInt($(this).find('.receiver_id_input').val()));
	});
	var wwidth = $(window).width();
	var W_Cap = Math.floor((wwidth - 230) / 290);
	if(count < W_Cap && !inArray(receiver, there)){
		$('#chat_windows_container').append(r);
		var calcSizes = true;
	}else if(!inArray(receiver, there)){
		$('.chat-window[data-id="'+there[0]+'"]').remove();
		$('#chat_windows_container').append(r);
		var calcSizes = true;
	}
		var thisWindow = $('.chat-window[data-id="'+receiver+'"]').find('.direct-chat-messages');
		thisWindow.scrollTop(thisWindow.prop('scrollHeight'));
	if(calcSizes){
		organizeWindows();
	}
}

function organizeWindows(){
	var xc = 0;
	if($('#control-sidebar-principal').hasClass('control-sidebar-open')){
		$('.chat-window').each(function(index, el) {
			if(xc == 0)
				$(this).css('right', 240);
			else
				$(this).css('right', (xc*282) + 240);
			xc++;
		});
	}else{
		$('.chat-window').each(function(index, el) {
			if(xc == 0)
				$(this).css('right', 10);
			else
				$(this).css('right', (xc*282) + 10);
			xc++;
		});
	}
}

function capWindows(){
	var wwidth = $(window).width();
	var W_Cap = Math.floor((wwidth - 230) / 290);
	var count = $('.chat-window').length;
	if(count > W_Cap){
		var times = count - W_Cap;
		$('.chat-window').each(function(index, el) {
			if(times > 0){
				$(this).remove();
				times--;
			}
		});
		organizeWindows();
	}
}

function insertMsg(id,msg,name,time,status,rec,which){
	var side = (which == 0) ? ' right' : '';
	var sideName = (which == 0) ? 'right' : 'left';
	var sideTime = (which == 0) ? 'left' : 'right';
	var message = ' <div class="direct-chat-msg'+side+'" data-id="'+id+'">';
    message +='   <div class="direct-chat-info clearfix">';
    message +='      <span class="direct-chat-name pull-'+sideName+'">'+name+'</span>';
    message +='      <span class="direct-chat-timestamp pull-'+sideTime+'">'+time+'</span>';
    message +='    </div><!-- /.direct-chat-info -->';
    message +='    <div class="direct-chat-text receiver-txt">';
    message +='      <i class="fa fa-check status-chat status-chat'+status+'" aria-hidden="true"></i>';
    message +='      '+msg+'<br>';
    message +='    </div><!-- /.direct-chat-text -->';
    $('.chat-window[data-id="'+rec+'"]').find('.direct-chat-messages').append(message);
    var thisWindow = $('.chat-window[data-id="'+rec+'"]').find('.direct-chat-messages');
	thisWindow.scrollTop(thisWindow.prop('scrollHeight'));
}
