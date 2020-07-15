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
                <h3>Invoice Pembayaran</h3>
                <br>
                <div class="table-responsive">
                    <table id="invoice_table" class="table ">
                        <thead>
                            <tr>
                                <th>Invoice Code#</th>
                                <th>Order Code#</th>
                                <th>Tanggal Invoice</th>
                                <th>Batas Invoice</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
            
                        </tbody>
                    </table>
                </div>
              </div>
            </div> 
        </div>
    </div>
</div>
