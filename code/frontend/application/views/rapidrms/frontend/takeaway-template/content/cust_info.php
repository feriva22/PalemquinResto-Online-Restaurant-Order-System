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
                <h3>Konfigurasi Akun</h3>

                <div class="row" style="margin-top: 50px;">
                <div class="col-md-6">
                    <form action="<?php echo base_url();?>customer/simpan_konfigurasi" method="post">
                        <input type="hidden" name="cst_id">
                        <div class="form-group">
                          <label for="cst_name" class="col-form-label">Nama:</label>
                          <input type="text" class="form-control" id="cst_name" name="cst_name" value="<?php echo $data['customer']->cst_name;?>" required placeholder="Nama">
                        </div>
                        <div class="form-group">
                          <label for="cst_phone" class="col-form-label">No HP:</label>
                          <input type="text" class="form-control" id="cst_phone" name="cst_phone" value="<?php echo $data['customer']->cst_phone;?>" required placeholder="No hp">
                        </div>
                        <div class="form-group">
                          <label for="cst_email" class="col-form-label">Email:</label>
                          <input type="email" class="form-control" id="cst_email" name="cst_email" value="<?php echo $data['customer']->cst_email;?>" readonly required placeholder="Email">
                        </div>
                        <div class="form-group">
                          <label for="cst_address" class="col-form-label">Alamat:</label>
                          <input type="text" class="form-control" id="cst_address" name="cst_address" value="<?php echo $data['customer']->cst_address;?>" required placeholder="Alamat">
                        </div>
                        <button type="submit" class="btn btn-success" >Simpan</button>
                    </form>
                </div>
                </div>

              </div>
            </div> 
        </div>
    </div>
</div>
