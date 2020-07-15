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
                <h3>Pembayaran</h3>
                <br>
                <div style="float:right;">
                    <a class="btn btn-success btn-sm" id="add_transaction" >
                        <i class="fa fa-plus"></i> Konfirmasi Pembayaran
                    </a>
                </div>
                <br><br>
                <div class="table-responsive">
                    <table id="transaction_table" class="table ">
                        <thead>
                            <tr>
                                <th>Transaction Code#</th>
                                <th>Invoice Code#</th>
                                <th>Tanggal Transaksi</th>
                                <th>Metode Pembayaran</th>
                                <th>Total</th>
                                <th>Status</th>
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

<!-- The modal for add new transaction -->
<div class="modal fade" id="add_transaction_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">Konfirmasi Pembayaran</h4>
	</div>
	<div class="modal-body">
      <form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>customer/add_transaction">
        <input type="hidden" name="trs_id">
        <div class="form-group">
          <label for="trs_invoicecode" class="col-form-label">Invoice Code:</label>
          <input type="text" class="form-control" id="trs_invoicecode" name="trs_invoicecode" required placeholder="Contoh : INV-000001">
        </div>
        <div class="form-group">
          <label for="trs_paygateway" class="col-form-label">Metode Pembayaran:</label>
          <input type="text" class="form-control" id="trs_paygateway" name="trs_paygateway" required placeholder="Contoh : bank bri">
        </div>
        <div class="form-group">
          <label for="trs_total" class="col-form-label">Total:</label>
          <input type="text" class="form-control" id="trs_total" name="trs_total" required placeholder="Contoh : 100000">
        </div>
        <div class="form-group">
          <label for="trs_photo" class="col-form-label">Bukti Transfer:</label>
          <input type="file" required class="form-control" id="trs_photo" name="trs_photo" >
        </div>
        <div class="form-group">
          <label for="trs_note" class="col-form-label">Catatan:</label>
          <textarea class="form-control" id="message-text" name="trs_note"></textarea>
        </div>
	</div>
	<div class="modal-footer">
	<button type="submit" class="btn btn-success" >Submit</button>
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	</div>
  </div>
  </form>
	</div>
</div>
