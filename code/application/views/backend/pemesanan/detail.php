<div class="main-content">
    <div class="container-fluid">

        <!-- MODAL INI BOS -->
        <div class="modal fade reservation-map-read" >
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="row ">
            <div class="col-md-8 mx-auto">
                <div class="text-center">
                    <div class="row ">
                        <div class="col-12" id="canvas-wrapper" style="overflow:auto">
                            <canvas id="canvas" width="627" height="396"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modalReservation" >
        	<div class="modal-dialog" role="document">
        	<div class="modal-content">
        	<div class="modal-header">
            <h4 class="modal-title" id="modalLabel">Reservasi tempat</h4>
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        	</button>
        	</div>
        	<div class="modal-body">
                <p>Ringkasan Reservasi Tempat anda :</p>
                <dl class="row">
                    <dt class="col-sm-3 col-md-3">Nomor Meja : </dt>
                    <dd class="col-sm-9 col-md-9"><span id="no_mejaReservation"></span> <a href="#" style="color: blue;" onclick="$('#modalReservation').modal('hide')">Ubah</a></dd>
                    <dt class="col-sm-3 col-md-3">Tanggal dan waktu : </dt>
                    <dd class="col-sm-9 col-md-9"><span id="date_Reservation"></span></dd>
                    <dt class="col-sm-3 col-md-3">Jumlah Orang : </dt>
                    <dd class="col-sm-9 col-md-9"><span id="people_Reservation"></span></dd>
                </dl>
                <p>Silahkan <strong>klik tombol Order</strong> dibawah untuk melanjutkan memilih Menu </p>
        	</div>
        	<div class="modal-footer">
        	<button type="button" class="btn btn-success btnSaveReservation" >Order</button>
        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        	</div>
        	</div>
        	</div>
        </div>

        <!-- MODAL INI BOS-->


        <div class="row" data-section="step-1" style="display:none;">
            <div class="col-md-8" >
                <div class="card  sticky-sidebar">
                    <div class="card-header"><h3>Item Pemesanan</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form class="sample-form">
                                    <div class="form-group">
                                        <label for="">Cari menu yang ingin ditambahkan</label>
                                        <select class=" form-control add-menu-search"></select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-hover table-responsive table-cart"  id="item-cart-table">
                            <thead><th class="w-25">Nama item</th><th class="w-10">Jenis</th><th class="w-15">Harga item</th><th class="w-10">Kuantitas</th>
                            <th class="w-20" style="text-align: right">Subtotal</th><th class="w-20">Aksi</th></thead>
                            <tbody  >
                               
                            </tbody>
                        </table>
                        <table class="table table-hover table-responsive " style="display: table;">
                            <tbody>
                                <tr>
                                <td colspan="2" class="text-right"><strong>Total</strong></td>
                                <td></td><td></td><td class="text-right"><strong id="item-cart-total">Rp.0</strong></td><td></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 " id="detail_wrapper" >
                <div class="card" >
                    <div class="card-header"  id="detail_title"><h3 >Tambah Pemesanan</h3></div>
                    <div class="card-body"  >
                    <form id="form_step-1" data-mode="">
                        <input type="hidden" id="ord_id" name="ord_id"/>
                        <div class="form-row">
                            <div class="form-group col-md-7">
                              <label for="ord_fordate">Pesanan untuk tanggal dan jam</label>
                              <div class="input-group date" id="ord_fordate_picker" data-target-input="nearest">                                 
                                  <input type="text" name="ord_fordate" id="ord_fordate" data-target="#ord_fordata_picker" class="form-control datetimepicker-input" placeholder="Klik tombol disamping">
                                  <div class="input-group-append" data-target="#ord_fordate_picker" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="ik ik-calendar"></i></div>
                                  </div>
                              </div>
                              <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group col-md-5">
                              <label for="odr_type" class="mr-3">Jenis pemesanan ?</label>
                            
                              <input type="checkbox" class="input-group switch-slider" name="odr_type" id="odr_type" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Katering" data-off="Reservasi" data-width="90">
                              <small class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 is-reservation" style="display:none;"> 
                                <label for="odr_people">Banyak orang</label>
                                <input type="text" name="odr_people" id="odr_people" class="form-control" placeholder="Masukkan banyak orang">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group col-md-6 mt-4 is-reservation" style="display:none;">
                                <button type="button" id="search-table-btn" class="btn btn-secondary btn-sm">Cari meja</button>
                            </div>
                            <span class="is-reservation" id="description-reservation"></span>
                        </div>
                        <br>
                        <button type="button" onclick="change_page('step-2')" class="btn btn-primary float-right">Lanjut</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" data-section="step-2" style="display:none;">
            <div class="col-md-8 "  >
                <div class="card" >
                    <div class="card-header" ><h3 >Opsi Pembayaran</h3></div>
                    <div class="card-body">
                        <form id="form_step-2" data-mode="">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="ord_discount">Pilih diskon</label>
                                    <select class="form-control" name="ord_discount" id="ord_discount">
                                      <option value="">Silahkan pilih</option>
                                      <?php foreach($data_diskon as $row){ ?>
                                          <option value="<?php echo $row->dsc_id; ?>" data-value="<?php echo $row->dsc_value;?>" 
                                          data-unit="<?php echo $row->dsc_unit == CASH ? 'cash' : 'percent';?>">
                                          <?php echo $row->dsc_name; ?>
                                      </option>
                                        <?php } ?>
                                    </select>
                                      <small class="form-text text-muted"></small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tax">Pajak </label>
                                    <select class="selectpicker form-control" name="tax_id[]" id="tax_id" multiple data-live-search="true">
                                      <?php foreach($data_pajak as $row){ ?>
                                          <option value="<?php echo $row->tax_id; ?>" data-value="<?php echo $row->tax_value;?>"
                                          data-unit="<?php echo $row->tax_unit == CASH ? 'cash' : 'percent';?>">
                                          <?php echo $row->tax_name;?>
                                          </option>
                                        <?php } ?>
                                    </select>
                                    <small class="form-text text-muted"></small>
                                </div>
                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 ">
                                    <label for="inv_paygateway">Pilih metode pembayaran</label>
                                    <select class="form-control" name="inv_paygateway" id="inv_paygateway">
                                      <option value="">Silahkan pilih</option>
                                      <?php foreach($data_paygateway as $row){ ?>
                                          <option value="<?php echo $row->pyg_id; ?>"><?php echo $row->pyg_name.'('.$row->pyg_detail.')'; ?></option>
                                        <?php } ?>
                                    </select>
                                      <small class="form-text text-muted"></small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ord_iscustdatabase">Identitas Pemesan</label>
                                        <br>
                                      <input type="checkbox" class="switch-slider" checked name="ord_iscustdatabase" id="ord_iscustdatabase" value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Dari database" data-off="Buat Sendiri" data-width="130">
                                      <small class="form-text text-muted"></small>
                                </div>
                            </div>
                            <hr>
                            <h5>Identitas Pemesan</h5>
                            <div class="form-row customer_db">
                                <div class="form-group col-md-6 ">
                                        <label for="inv_customer">Pilih customer</label>
                                        <select class="form-control" name="inv_customer" id="inv_customer">
                                          <option value="">Silahkan pilih</option>
                                          <?php foreach($data_customer as $row){ ?>
                                              <option value="<?php echo $row->cst_id; ?>"><?php echo $row->cst_name; ?></option>
                                            <?php } ?>
                                        </select>
                                          <small class="form-text text-muted"></small>
                                </div>
                            </div>
                            <div class="form-row customer_created" style="display:none;">
                                <div class="form-group col-md-4">
                                    <label for="cst_name">Nama</label>
                                        <input type="text" name="cst_name" id="cst_name" class="form-control" placeholder="Masukkan nama">
                                      <small class="form-text text-muted"></small>
                                </div>
                                <div class="form-group col-md-4 ">
                                    <label for="cst_phone">Nomor Handphone</label>
                                        <input type="text" name="cst_phone" id="cst_phone" class="form-control" placeholder="Masukkan nomor handphone" required>
                                      <small class="form-text text-muted"></small>
                                </div>
                                <div class="form-group col-md-4 ">
                                    <label for="cst_address">Alamat</label>
                                        <input type="text" name="cst_address" id="cst_address" class="form-control" placeholder="Masukkan alamat pelanggan">
                                      <small class="form-text text-muted"></small>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="font-weight-bold">Detail Pembayaran</span><br>
                                    <div class="row clearfix">
                                        <div class="col-md-6 col-sm-6" id="description-payment">    
                                            <span data-id="item-1">Total Item menu</span><br>
                                            <span data-id="diskon-1">Diskon akhir tahun 10%</span><br>
                                            <span data-id="pajak-1">Pajak Ppn 10%</span><br>
                                        </div>
                                        <div class="col-md-6 col-sm-6 value-payment" id="value-payment">
                                            <span class="text-primary" data-value="item-1">+Rp. 50000</span><br>
                                            <span class="text-danger" data-value="diskon-1">-Rp. 5000</span><br>
                                            <span class="text-primary" data-value="pajak-1">+Rp. 5000</span><br>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right clearfix mt-3">
                                        <h5>Total</h5>
                                        <h5 id="grand-total">Rp. 50000</h5>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 " id="detail_wrapper" >
                <div class="card" >
                    <div class="card-header" id="detail_title"><h3 >Detail Pemesanan</h3></div>
                    <div class="card-body"  >
                    <form id="form_step-2" data-mode="">
                        <div class="form-row">
                            <div class="form-group col-md-6 is-reservation-addr">
                                <label for="ord_isdelivery">Apakah diantar ?</label>
                                  <input type="checkbox" class="switch-slider" name="ord_isdelivery" id="ord_isdelivery" value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Ya" data-off="Tidak" data-width="90">
                                  <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ord_isdp">Tipe pembayaran</label>
                                  <input type="checkbox" class="switch-slider" name="ord_isdp" id="ord_isdp" value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="DP" data-off="Lunas" data-width="90">
                                  <small class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="form-group is-delivered" style="display: none;">
                          <label for="ord_delivaddress">Alamat pengiriman</label>
                          <input type="text" name="ord_delivaddress" id="ord_delivaddress" class="form-control" placeholder="Masukkan alamat pengiriman">
                          <small class="form-text text-muted">contoh : jln kemangi</small>
                        </div>
                        <div class="form-row is-delivered" style="display: none;">
                            <div class="form-group col-md-4" >
                              <label for="ord_delivcity">Kota pengiriman</label>
                              <input type="text" name="ord_delivcity" id="ord_delivcity" class="form-control" placeholder="Masukkan kota pengiriman">
                              <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group col-md-4" >
                              <label for="ord_delivprovince">Provinsi pengiriman</label>
                              <input type="text" name="ord_delivprovince" id="ord_delivprovince" class="form-control" placeholder="Masukkan provinsi pengiriman">
                              <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group col-md-4" >
                              <label for="ord_delivzip">Kode Area pengiriman</label>
                              <input type="text" name="ord_delivzip" id="ord_delivzip" class="form-control" placeholder="Masukkan kode area">
                              <small class="form-text text-muted"></small>
                            </div>
                        </div>
                          <button type="button" class="btn btn-primary float-right" id="submit-data">Submit</button>
                          <button type="button" onclick="change_page('step-1')"class="btn btn-secondary float-right mr-2">Kembali</button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</div>