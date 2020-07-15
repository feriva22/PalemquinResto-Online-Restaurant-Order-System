function onSignIn(googleUser) {

    var id_token = googleUser.getAuthResponse().id_token;
    var submitted_data = {
        idtoken: id_token
    };
    $.ajax({
        url: base_url + 'auth/login_google',
        type: 'POST',
        data: submitted_data,
        success: function(resp){
            console.log(resp);
            resp = JSON.parse(resp);
            if(resp.status == 'success'){
                console.log(resp);
                //redirect ke dashboard / index
                show_notification(resp.status,resp.message);
                var redir_url = resp.redir;
                setTimeout(()=>{
                    document.location = redir_url ? redir_url : base_url;
                },1500);
            }else{
                show_notification(resp.status,resp.message);
                gapi.auth2.getAuthInstance().signOut();
            }
        },
        error: function(evt){
            show_notification('error','Error terhubung dengan serve');
            gapi.auth2.getAuthInstance().signOut();
        }
    });
}

function onLoad() {
    gapi.load('auth2', function() {
        gapi.auth2.init();
    });
}

function signOut() {
    if(typeof(gapi) !== 'undefined'){
        gapi.auth2.getAuthInstance().signOut();
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            window.location = base_url + "auth/logout";
        });
    }else{
        window.location = base_url + "auth/logout";
    }
}
