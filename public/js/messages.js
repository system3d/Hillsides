function flashSuccess(text, title, transition, close, hide, stack, position, align, loader){
	flashMessage('success', text, title, transition, close, hide, stack, position, align, loader);
}

function flashDanger(text, title, transition, close, hide, stack, position, align, loader){
	flashMessage('error', text, title, transition, close, false, stack, position, align, loader);
}

function flashWarning(text, title, transition, close, hide, stack, position, align, loader){
	flashMessage('warning', text, title, transition, close, hide, stack, position, align, loader);
}

function flashInfo(text, title, transition, close, hide, stack, position, align, loader){
	flashMessage('info', text, title, transition, close, hide, stack, position, align, loader);
}

function flashDefault(text, title, transition, close, hide, stack, position, align, loader){
	flashMessage('none', text, title, transition, close, hide, stack, position, align, loader);
}

function flashNotify(style, text, title, transition, close, hide, stack, position, align, loader){
	flashMessage(style, text, title, transition, close, false, stack, 'bottom-right', align, loader);
}

function flashInfoCenter(text, title, transition, close, hide, stack, position, align, loader){
	flashMessage('info', text, '', transition, close, false, stack, 'top-center', align, loader);
}

function flashMessage(style, text, title, transition, close, hide, stack, position, align, loader){
	if(style == 'danger') style == 'error';
	var defaults = text+"&"+title+"&"+transition+"&"+close+"&"+hide+"&"+stack+"&"+position+"&"+align+"&"+loader;
	var data = setDefaults(defaults);
	if(style == 'error')
		data[4] = false;
	if(style == 'none'){
		$.toast({
	    text: data[0], // Text that is to be shown in the toast
	    heading: data[1], // Optional heading to be shown on the toast
	    bgColor: '#444444',  // Background color of the toast
   		textColor: '#eeeeee',  // Text color of the toast
	    showHideTransition: data[2], // fade, slide or plain
	    allowToastClose: data[3], // Boolean value true or false
	    hideAfter: data[4], // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
	    stack: data[5], // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
	    position: data[6], // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
	    textAlign: data[7],  // Text alignment i.e. left, right or center
	    loader: data[8],  // Whether to show loader or not. True by default
	});
	}else{
		$.toast({
		    text: data[0], // Text that is to be shown in the toast
		    heading: data[1], // Optional heading to be shown on the toast
		    icon: style, // Type of toast icon
		    showHideTransition: data[2], // fade, slide or plain
		    allowToastClose: data[3], // Boolean value true or false
		    hideAfter: data[4], // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
		    stack: data[5], // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
		    position: data[6], // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
		    textAlign: data[7],  // Text alignment i.e. left, right or center
		    loader: data[8],  // Whether to show loader or not. True by default
		});
	}
}

function setDefaults(dados){
	var dados = dados.split('&');
	var data = [];
	data[0] = dados[0];
	data[1] =  dados[1] !== 'undefined' ? dados[1] : ' ';
	data[2] =  dados[2] !== 'undefined' ? dados[2] : 'fade';
	data[3] =  dados[3] !== 'undefined' ? dados[3] : true;
	data[4] =  dados[4] !== 'undefined' ? dados[4] : 5000;
	data[5] =  dados[5] !== 'undefined' ? dados[5] : 5;
	data[6] =  dados[6] !== 'undefined' ? dados[6] : 'top-center';
	data[7] =  dados[7] !== 'undefined' ? dados[7] : 'left';
	data[8] =  dados[8] !== 'undefined' ? dados[8] : true;
	return data;
}