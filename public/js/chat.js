$(document).ready(function($) {
	$('#toggleChatList').click(function(event) {
		if($(this).parent('#chat_users_list').hasClass('collapsed-box'))
			updateChatStatus();
	});

	$('#chat_search_field').keyup(function(event) {
		var search = $(this).val();
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
	});

	$(document).on('click', '.chat_user', function(event) {
		event.preventDefault();
		var sender = thisUserId;
		var receiver = $(this).attr('data-id');
		createChatWindow(sender,receiver);
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
	 	});
}

function chatWindowCreator(r,receiver){
	var count = $('.chat-window').length;
	var x = 0;
	var there = [];
	$('.chat-window').each(function(index, el) {
		there.push(parseInt($(this).find('.receiver_id_input').val()));
	});
	if(count < 3 && !inArray(receiver, there)){
		$('#chat_windows_container').append(r);
	}else if(!inArray(receiver, there)){
		$('.chat-window[data-id="'+there[0]+'"]').remove();
		$('#chat_windows_container').append(r);
	}
	
}
