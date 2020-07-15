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
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-default-red" >
            <div class="panel-heading">
                <div class="panel-title">Login Akun</div>
                <!--<div style="float:right; font-size: 100%; position: relative; top:-10px;"><a href="#" style="color:#ffff;">Lupa Password?</a></div>-->
            </div>     
            <div style="padding-top:30px" class="panel-body" >
                <!--    
                <form id="loginform" class="form-horizontal"  method="POST" action="<?php echo base_url();?>Auth/login_act">
                            
                    <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input id="login-email" type="text" class="form-control" name="email" placeholder="email">                                        
                            </div>
                        
                    <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                            </div>
                            
                        
                    <div class="input-group">
                            <div class="checkbox">
                                <label>
                                <input id="login-remember" type="checkbox" name="remember" value="1"> Ingat saya
                                </label>
                            </div>
                            </div>
                        <div style="margin-top:10px" class="form-group">
                            
                            <div class="col-sm-12 controls">
                                <input type="submit" id="btn-login" class="btn btn-default-red" value="Login">
                            </div>-->
                            <div class="col-sm-12 controls">
                                <div class="float-left mr-2" style="padding-top: 10px">Login dengan Email Google</div>          
                                <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>        
                            </div>
                        <!--</div>-->
                        <!--
                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                    Anda masih belum punya akun ? 
                                <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()" >
                                    <strong>Daftar Akun Baru Disini</strong>
                                </a>
                                </div>
                            </div>
                        </div>  
                      
                    </form> -->
                </div>                     
            </div>  
        </div>
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-default-red">
                <div class="panel-heading">
                    <div class="panel-title">Daftar Akun</div>
                    <div style="float:right; font-size: 100%; position: relative; top:-10px"><a id="signinlink" style="color:#ffff;" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Login </a></div>
                </div>  
                <div class="panel-body" >
                    <form id="signupform" class="form-horizontal" method="POST" role="form" action="<?php echo base_url();?>Auth/register_act">
                        <div class="form-group">
                            <label for="username" class="col-md-3 control-label">Username</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="username" placeholder="UserName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-3 control-label">Password</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-3 control-label">Konfirmasi Password</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="confpassword" placeholder="Masukkan Password Lagi" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Button -->                                        
                            <div class="col-md-offset-3 col-md-9">
                                <input type="submit" id="btn-signup" type="button" class="btn btn-default-red" value="Daftar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
</div>