<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-utensils bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi Transaksi</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url();?>backend/dashboard"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title;?>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="slide-content col-md-12" id="table_wrapper">
                <div class="card">
                    <div class="card-header"><h3><?php echo $page_title;?></h3></div>
                    <div class="card-body">
                        <div class="row clearfix">
                          <div class="col-md-6">
                            <form class="sample-form">
                            <div class="form-group">
                              <label for="invoice-code-filter">Filter invoice code</label><br>
                              <select class=" form-control invoice-code-filter w-50"></select>
                            </div>
                            </form>
                          </div>
                          <div class="col-md-6 clearfix">
                            <div class="float-sm-right">
                              <a class="btn btn-success btn-sm add_role" id="add_act" >
                                  <i class="fas fa-plus"></i> Tambah
                              </a>
                            </div>
                          </div>
                        </div>
                        <div class="table-responsive">
                        <table id="transaksi_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Transaksi Code</th>
                                    <th>Tanggal</th>
                                    <th>Invoice Code</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Total</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Note</th>
                                    <th>Bukti Foto</th>
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
            <div class="col-md-4" id="detail_wrapper" style="display: none;">
                <div class="card">
                    <div class="card-header" id="detail_title"><h3></h3></div>
                    <div class="card-body">
                    <form id="form_detail" data-mode="">
                        <input type="hidden" id="trs_id" name="trs_id"/>
                          <div class="form-group field-edit">
                            <label for="trs_code">Transaksi Code</label>
                            <div class="col-md-12 p-0">
                                    <div id="trs_code"></div>
                            </div>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="trs_date">Tanggal Transaksi</label>
                            <div class="col-md-12 p-0">
                                    <div id="trs_date"></div>
                            </div>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                          <label for="trs_invoicecode">Invoice Code</label>
                            <input type="text" name="trs_invoicecode" id="trs_invoicecode" class="form-control" placeholder="Masukkan invoice code ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                          <label for="trs_paygateway">Metode Pembayaran</label>
                            <select class="form-control" name="trs_paygateway" id="trs_paygateway" >
                                <option value="">Silahkan pilih</option>
                              <?php foreach($data_paygateway as $row){ ?>
                                  <option value="<?php echo $row->pyg_name; ?>"><?php echo $row->pyg_name.' '.$row->pyg_detail; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="trs_total">Total</label>
                            <input type="text" name="trs_total" id="trs_total" class="form-control" placeholder="Masukkan harga ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="trs_name">Nama</label>
                            <input type="text" name="trs_name" id="trs_name" class="form-control" placeholder="Masukkan nama ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="trs_email">Email</label>
                            <input type="text" name="trs_email" id="trs_email" class="form-control" placeholder="Masukkan email ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="trs_note">Note</label>
                            <input type="text" name="trs_note" id="trs_note" class="form-control" placeholder="Masukkan catatan ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="trs_photo">Bukti Foto</label>
                            <input type="file" multiple accept="image/x-png,image/gif,image/jpeg" title="Upload Image" id="trs_photo" name="trs_photo" />
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="form_preview">Preview</label>
                            <img id="form_preview" class="img-fluid" />
                          </div>
                          <div class="form-group field-edit">
                            <label for="trs_status">Status</label>
                            <select class="form-control" name="trs_status" id="trs_status">
                              <option value="">Silahkan pilih</option>
                              <option value="<?php echo WAITING;?>">Menunggu konfirmasi</option>
                              <option value="<?php echo ACCEPTED;?>">Diterima</option>
                              <option value="<?php echo REJECTED;?>">Ditolak</option>
                            </select>
                          </div>
                          <button type="submit" class="btn btn-primary float-right">Submit</button>
                          <button type="button" class="btn btn-light float-right mr-2" onclick="hide_detail()">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>