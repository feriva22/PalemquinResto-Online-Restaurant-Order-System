<div class="container" style="margin-top: 50px;">
	<div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Navigasi</div>
              <!-- List group -->
              <ul class="list-group">
                <li class="list-group-item"><a href="<?php echo base_url();?>customer/">Dashboard</a></li>
                <li class="list-group-item"><a href="<?php echo base_url();?>customer/invoice">Invoice</a></li>
                <li class="list-group-item"><a href="<?php echo base_url();?>customer/transaksi">Pembayaran</a></li>
                <li class="list-group-item"><a href="<?php echo base_url();?>customer/konfigurasi">Konfigurasi Akun</a></li>
                <li class="list-group-item"><a href="<?php echo base_url();?>auth/logout" onclick="signOut();return false;">Logout</a></li>
              </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
              <div class="panel-body">
                <h3>Hallo <?php echo $data['customer']->cst_name;?> !</h3>

                <div class="row" style="margin-top: 50px;">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h2><?php echo $data['trs_accepted'];?></h2>
                            </div>
                            <div class="panel-footer text-center" style="background-color: #80ff80">
                            Pembayaran Diterima
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h2><?php echo $data['inv_unpaid'];?></h2>
                            </div>
                            <div class="panel-footer text-center" style="background-color: #ffff80">
                            Invoice Belum Terbayar
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <h2><?php echo $data['trs_rejected'];?></h2>
                            </div>
                            <div class="panel-footer text-center" style="background-color: #ff8080">
                            Pembayaran Ditolak
                            </div>
                        </div>
                    </div>
                </div>

              </div>
            </div> 
        </div>
    </div>
</div>
