function show_notification(status,message){
    icon = {
        'success': 'success',
        'warning': 'warning',
        'error'  : 'danger'
    };
    $.toast({
        text: message, 
        heading: 'Notifikasi', 
        icon: icon[status], 
        showHideTransition: 'slide', 
        allowToastClose: true, 
        hideAfter: 1500, 
        position: 'top-center', 
        textAlign: 'left'
      });
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}