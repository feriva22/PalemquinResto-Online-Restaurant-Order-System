<?php if ($this->session->flashdata('alert')) : ?>
    <script>
        window.onload = function(){
            $.toast({
                text: "<?php echo $this->session->flashdata('alert')['msg'];?>", 
                heading: "Pesan dari sistem", 
                icon: '<?php echo $this->session->flashdata('alert')['status'];?>', 
                showHideTransition: 'slide', 
                allowToastClose: true, 
                hideAfter: 5000, 
                position: 'top-center', 
                textAlign: 'left'
            });
        }
    </script>
<?php endif; ?>
<div class="container">
    <div id="loginbox" style="margin-top:50px;" class=" col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-default-red" >
            <div class="panel-heading">
                <div class="panel-title"><h3>Akun anda belum teraktivasi</h3></div>
                <div style="float:right; font-size: 100%; position: relative; top:-10px;"><a href="#" style="color:#ffff;">Lupa Password?</a></div>
            </div>   
            <div style="padding-top:30px" class="panel-body" >
                <p>Silahkan konfirmasi terlebih dahulu dengan klik link yang terkirim ke email anda</p>
                <p>Jika pesan email tidak ada diinbox anda, silahkan <a href="<?php echo base_url();?>auth/send_email_confirmation" style="color:blue;">kirim lagi<a></p>
            </div>
        </div>
    </div>

</div>