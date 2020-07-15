function ajaxExtend(options,always){   //untuk memasukkan csrf tiap call ajax
    options.data[csrf_name] = Cookies.get(csrf_name);
	if(typeof(options.data[csrf_name]) == 'undefined'){
		//refresh if csrf token is not found
		document.location = document.location;
		return;
	}
	$.ajax({
        url: options.url,
        type: 'post',
        data: options.data,
        success: options.success,
        error: options.error,
        dataType : 'json',
        cache: false
    }).always(always);
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function show_alert(status, message){
    final_string = message;
    if(typeof(message) === 'object'){
        final_string = '';
        Object.keys(message).forEach(function(key){
            final_string += `${message[key]}\n`;
        })
    }
    $('#alert_notice').append(`
                            <div class="alert alert-${status} alert-dismissible fade show" id="" role="alert">
                            <strong>${status} !</strong> ${final_string}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ik ik-x"></i></button></div>`);
}

function show_notification(status,message){
    var notif_type = {
        'success' : { icon: 'success',loaderBg: '#f96868' },
        'warning' : { icon: 'warning',loaderBg: '#57c7d4'},
        'error'   : { icon: 'error',loaderBg: '#f2a654'}
    };
    $.toast({
        heading: status,
        text: message,
        showHideTransition: 'slide',
        icon: notif_type[status].icon,
        loaderBg: notif_type[status].loaderBg,
        position: 'top-right',
        hideAfter: 2000
      })
}

function page_click(selector,action){
    $('body').on('click',selector,action);
}

function toCurrency(number){
    return parseInt(number).toLocaleString(undefined,{minimumFractionDigits:2});
}

