$(document).ready(function() {

	$(document).on('click', '#new-est-side', function(event) {
		event.preventDefault();
		var thisLink = $(this).find('i');
		// $(this).addClass('fa-spin');
		var value = $('#novo-estagio-set').val();
		if(value.length > 0){
			$(this).find('i').toggleClass('fa-check fa-spinner').addClass('fa-spin');
			$.ajax({
		    url: urlbaseGeral+"/settings/gravarEstagio",
		    type: 'POST',
		    data: {value:value},
		    dataType: 'json',
		    }).done(function(r) {
	    	flashMessage(r.status, r.msg);
		    if(r.status == 'success'){
		    	$('#novo-estagio-set').val('');
		    	$('#estagios-sets-wrap').append('<p id="EsO'+r.id+'">'+r.desc+' <a href="#" data-toggle="tooltip" data-html="true" title="Deletar" class="pull-right delete-estagio text-red"><i class="fa fa-trash"></i></a></p>');
		    }
		  	thisLink.toggleClass('fa-spinner fa-check').removeClass('fa-spin');
		    });
		}else{
			flashMessage('error', 'Nenhum Valor Informado');
		}
	});

	$(document).on('click', '.delete-estagio', function(event) {
		event.preventDefault();
		var idx = $(this).parent('p').attr('data-id');
		var thisP = $(this).parent('p');
		$.ajax({
		    url: urlbaseGeral+"/settings/deleteEstagio",
		     type: 'POST',
		    data: {id:idx},
		    dataType: 'json',
	    }).done(function(r) {
    	 	flashMessage(r.status, r.msg);
    	 	if(r.status == 'success'){
    	 		thisP.remove();
    	 	}
	    });
	});

	$(document).on('click', '#new-stp-side', function(event) {
		event.preventDefault();
		var thisLink = $(this).find('i');
		var value = $('#novo-stp-set').val();
		if(value.length > 0){
			$(this).find('i').toggleClass('fa-check fa-spinner').addClass('fa-spin');
			$.ajax({
		    url: urlbaseGeral+"/settings/gravarStp",
		    type: 'POST',
		    data: {value:value},
		    dataType: 'json',
		    }).done(function(r) {
	    	flashMessage(r.status, r.msg);
		    if(r.status == 'success'){
		    	$('#novo-stp-set').val('');
		    	$('#stp-sets-wrap').append('<p data-id="'+r.id+'">'+r.desc+' <a href="#" data-toggle="tooltip" data-html="true" title="Deletar" class="pull-right delete-stp text-red"><i class="fa fa-trash"></i></a></p>');
		    }
		  	thisLink.toggleClass('fa-spinner fa-check').removeClass('fa-spin');
		    });
		}else{
			flashMessage('error', 'Nenhum Valor Informado');
		}
	});

	$(document).on('click', '.delete-stp', function(event) {
		event.preventDefault();
		var idx = $(this).parent('p').attr('data-id');
		var thisP = $(this).parent('p');
		$.ajax({
		    url: urlbaseGeral+"/settings/deleteStp",
		     type: 'POST',
		    data: {id:idx},
		    dataType: 'json',
	    }).done(function(r) {
    	 	flashMessage(r.status, r.msg);
    	 	if(r.status == 'success'){
    	 		thisP.remove();
    	 	}
	    });
	});

	$(document).on('click', '#new-trp-side', function(event) {
		event.preventDefault();
		var thisLink = $(this).find('i');
		var value = $('#novo-trp-set').val();
		if(value.length > 0){
			$(this).find('i').toggleClass('fa-check fa-spinner').addClass('fa-spin');
			$.ajax({
		    url: urlbaseGeral+"/settings/gravarTrp",
		    type: 'POST',
		    data: {value:value},
		    dataType: 'json',
		    }).done(function(r) {
	    	flashMessage(r.status, r.msg);
		    if(r.status == 'success'){
		    	$('#novo-trp-set').val('');
		    	$('#trp-sets-wrap').append('<p data-id="'+r.id+'">'+r.desc+' <a href="#" data-toggle="tooltip" data-html="true" title="Deletar" class="pull-right delete-trp text-red"><i class="fa fa-trash"></i></a></p>');
		    }
		  	thisLink.toggleClass('fa-spinner fa-check').removeClass('fa-spin');
		    });
		}else{
			flashMessage('error', 'Nenhum Valor Informado');
		}
	});

	$(document).on('click', '.delete-trp', function(event) {
		event.preventDefault();
		var idx = $(this).parent('p').attr('data-id');
		var thisP = $(this).parent('p');
		$.ajax({
		    url: urlbaseGeral+"/settings/deleteTrp",
		     type: 'POST',
		    data: {id:idx},
		    dataType: 'json',
	    }).done(function(r) {
    	 	flashMessage(r.status, r.msg);
    	 	if(r.status == 'success'){
    	 		thisP.remove();
    	 	}
	    });
	});

	$("#estagios-sets-wrap").sortable({
        tolerance: 'pointer',
       placeholder: "placeholderWrapper",
      	axis: "y",
      	 cursor: "move",
      	 revert: true,
        forceHelperSize: true,
        forcePlaceholderSize: true,
         stop: function( event, ui ) {
        	var sorted = $( "#estagios-sets-wrap" ).sortable( "toArray" );
        	$.ajax({
		    url: urlbaseGeral+"/settings/setOrder",
		     type: 'POST',
		    data: {sorted:sorted},
	    	})
        },
    });

});
