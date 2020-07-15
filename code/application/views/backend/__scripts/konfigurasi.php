<script type="text/javascript">
$(document).ready(function() {

    $('#allowed_deliveryaddr').tokenfield({})
    $('#config-form').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        formData.append(csrf_name,Cookies.get(csrf_name));//append csrf
        $.ajax({
            url: base_url+'backend/konfigurasi/save',
            data: formData,
            type: 'post',
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: (resp)=>{
                if(isJson(resp)) {resp = JSON.parse(resp);}
                if(typeof(resp.status) !== 'undefined') {show_notification(resp.status,resp.message);}
                else {show_notification('error','Anda tidak memiliki akses');}
            },
            error: ()=>{
                show_notification('error','Error Connecting Server');
            }
        })
    })
})
</script>