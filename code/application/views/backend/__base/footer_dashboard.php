                <footer class="footer">
                    <div class="w-100 clearfix">
                        <span class="text-center text-sm-left d-md-inline-block">Copyright © 2019 ThemeKit v2.0. All Rights Reserved.</span>
                        <!--<span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Crafted with <i class="fa fa-heart text-danger"></i> by <a href="http://lavalite.org/" class="text-dark" target="_blank">Lavalite</a></span>-->
                    </div>
                </footer>  
            </div>
        </div>

        <script>
            var base_url = '<?php echo base_url();?>';
            var csrf_name = '<?php echo $this->security->get_csrf_token_name();?>';
        </script>
        <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/popper.js/dist/umd/popper.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/moment/moment.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/select2/js/select2.min.js"></script>
        <script src="<?php echo base_url();?>assets/dist/js/theme.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/jquery-toast/js/jquery.toast.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/js.cookie.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/fabricjs/fabric.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.min.js"></script>

        
        <?php if(!empty($plugin)):?>
            <!-- add js plugin -->
            <?php foreach($plugin as $js):?>
                <script type="text/javascript" src="<?php echo base_url().''.$js;?>"></script>
            <?php endforeach;?>
        <?php endif;?>

        <script src="<?php echo base_url();?>assets/dist/js/site.js"></script>
        <script src="<?php echo base_url();?>assets/dist/js/masterTemplate.js"></script>

        <?php if(!empty($custom_js)):?>
            <!-- user defined js -->
            <?php
            $this->view($custom_js['src'],$custom_js['data']); 
            ?>
        <?php endif;?>
        
    </body>
</html>
