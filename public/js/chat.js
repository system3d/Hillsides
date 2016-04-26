$(document).ready(function($) {
	$('#toggleChatList').click(function(event) {
		$(this).parent('#chat_users_list').toggleClass('collapsed-box');
		$('#chat_is_toggle').toggleClass('fa-minus fa-plus');
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
});