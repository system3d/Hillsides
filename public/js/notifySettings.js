 $(document).ready(function(){

 	$('.box-s-collapse-radio').click(function(event) {
 		var box = $('.NotifySettings').children(".box");
    //Find the body and the footer
	    var bf = box.find(".box-body");

	        bf.slideUp();
	 	
	$('form.NotifySettings input:checkbox').each(function(){
        $(this).prop('checked',false);
   }) 
 	var box2 = $(this).parent(".box");
    //Find the body and the footer
	    var bf2 = box2.find(".box-body");

	        bf2.slideDown();

	    $(this).find('.radio-s-which').prop('checked', true);

	    event.stopPropagation();
});

 	$('.NotifySettings').submit(function(event) {
 		event.preventDefault();
 		$('#loader').removeClass('hidden');
 		var form = $(this).serializeAndEncode().replace(/%5B%5D/g, '[]');;
 		$.ajax({
		    url: urlbaseGeral+"/notificacoes/settingsGravar",
		    type: 'POST',
		    dataType: 'html',
		    data: {form: form},
		    success: function(r){
	    	 $('#loader').addClass('hidden');
	    	 var rx = r.split('&');
         	 flashMessage(rx[0], rx[1]);
		    }
		  })
 	});
 });


 $.fn.serializeAndEncode = function() {
      return $.map(this.serializeArray(), function(val) {
        return [val.name, encodeURIComponent(val.value)].join('=');
      }).join('&');
    };

