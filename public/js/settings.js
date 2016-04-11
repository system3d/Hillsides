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
		    	$('#estagios-sets-wrap').append('<p data-id="'+r.id+'">'+r.desc+' <a href="#" data-toggle="tooltip" data-html="true" title="Deletar" class="pull-right delete-estagio text-red"><i class="fa fa-trash"></i></a></p>');
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
		var idx = $(this).closest('p').attr('data-id');
		var thisP = $(this).closest('p');
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

	$(document).on('click', '#new-sfp-side', function(event) {
		event.preventDefault();
		var thisLink = $(this).find('i');
		var value = $('#novo-sfp-set').val();
		if(value.length > 0){
			$(this).find('i').toggleClass('fa-check fa-spinner').addClass('fa-spin');
			$.ajax({
		    url: urlbaseGeral+"/settings/gravarSfp",
		    type: 'POST',
		    data: {value:value},
		    dataType: 'json',
		    }).done(function(r) {
	    	flashMessage(r.status, r.msg);
		    if(r.status == 'success'){
		    	$('#novo-sfp-set').val('');
		    	$('#sfp-sets-wrap').append('<p data-id="'+r.id+'">'+r.desc+' <a href="#" data-toggle="tooltip" data-html="true" title="Deletar" class="pull-right delete-sfp text-red"><i class="fa fa-trash"></i></a></p>');
		    }
		  	thisLink.toggleClass('fa-spinner fa-check').removeClass('fa-spin');
		    });
		}else{
			flashMessage('error', 'Nenhum Valor Informado');
		}
	});

	$(document).on('click', '.delete-sfp', function(event) {
		event.preventDefault();
		var idx = $(this).closest('p').attr('data-id');
		var thisP = $(this).closest('p');
		$.ajax({
		    url: urlbaseGeral+"/settings/deleteSfp",
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
		    	$('#trp-sets-wrap').append('<p data-id="'+r.id+'">'+r.desc+'<span class="pull-right"><a href="#" data-id='+r.id+' data-toggle="tooltip" data-html="true" title="Cor de Fundo" class="fire-bck-change"><span id="BTCS'+r.id+'" class="back-t-change" style="background:'+r.cor+'"></span></a> <a href="#" data-id="'+r.id+'" data-toggle="tooltip" data-html="true" title="Trocar Icone" class="icon-t-change" style="margin-right:4px"><img class="img-circle img-icon" src="'+urlbaseGeral+'/img/icones/default.png" id="t-icon-'+r.id+'"></a><a href="#" data-toggle="tooltip" data-html="true" title="Deletar" class="delete-trp text-red"><i class="fa fa-trash"></i></a></span></p>');
		    }
		  	thisLink.toggleClass('fa-spinner fa-check').removeClass('fa-spin');
		    });
		}else{
			flashMessage('error', 'Nenhum Valor Informado');
		}
	});

	$(document).on('click', '.delete-trp', function(event) {
		event.preventDefault();
		var idx = $(this).parent('span').parent('p').attr('data-id');
		var thisP = $(this).parent('span').parent('p');
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

	$(document).on('click', '.icon-t-change', function(event) {
		event.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
	    url: urlbaseGeral+"/settings/setIcon",
	    type: 'POST',
	    data:{id:id},
	    dataType: 'html',
		  })
		  .done(function(response) {
		  	drawModal(response, '25%');
		  });
	});

	$(document).on('click', '.fire-bck-change', function(event) {
		event.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
	    url: urlbaseGeral+"/settings/setColor",
	    type: 'POST',
	    data:{id:id},
	    dataType: 'html',
		  })
		  .done(function(response) {
		  	drawModal(response, '25%');
		  	$('.colorPickBck').colorpicker();
		  	$('.colorPickBck').colorpicker().on('changeColor.colorpicker', function(event){
		  	  var color = event.color.toHex();
			  $('#colorSelected').css('background', color);
			});
    
		  });
	});

	$(document).on('focus', '.colorPickBck', function(event) {
		$('#colorSelected').css('border-color', '#3c8dbc');
	});

	$(document).on('blur', '.colorPickBck', function(event) {
		$('#colorSelected').css('border-color', '#d2d6de');
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
        	var sorted = $( "#estagios-sets-wrap" ).sortable( "toArray", { attribute: 'data-id' } );
        	dd(sorted);
        	$.ajax({
		    url: urlbaseGeral+"/settings/setOrder",
		     type: 'POST',
		    data: {sorted:sorted},
	    	})
        },
    });

    $(document).on('submit', '#trocar_icone', function(event) {
    	event.preventDefault();
    	var formData = new FormData(this);
    	 $.ajax({
            type:'POST',
            url: urlbaseGeral+"/settings/storeIcon",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
        }).done(function(r) {
    	 	flashMessage(r.status, r.msg);
    	 	if(r.status == 'success'){
    	 		var today = new Date();
    	 		$('#t-icon-'+r.idt).attr("src",r.img+'?'+today.getTime());
    	 	}
    	 	$('#modal').modal("hide");
	    });
    });

     $(document).on('submit', '#trocar_cor', function(event) {
     	event.preventDefault();
     	var values = $(this).serializeAndEncode();
     	$.ajax({
	      url: urlbaseGeral+"/settings/storeColor",
	      data: {dados: values},
	      type: 'POST',
	      dataType: 'json',
	    }).done(function(r){
	      flashMessage(r.status, r.msg);
	      $('#modal').modal("hide");
	      if(r.status == 'success'){
	      	$('#BTCS'+r.id).css('background', r.cor);
	      }
	    })
     });

});
