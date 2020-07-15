<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">

    $("#formLogin").submit(function(e){
        e.preventDefault();
        ajaxExtend({
            url: base_url+'backend/login/authenticate',
            data: {
                username: $("#username").val(),password: $("#password").val()  
            },
            success: (resp) => { 
                if(resp.status == "success"){
                    show_alert('success',resp.message);
                    //success login redir to redi_page
                    document.location = base_url+resp.data.redir;
                }else{
                    show_alert('warning',resp.message);
                }
            },
            error: (err) => { show_alert('danger','Error connecting to server'); document.location = base_url+'backend/login'
                ; 
            }
        })
    })
</script>