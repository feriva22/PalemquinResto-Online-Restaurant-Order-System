<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-utensils bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi pajak</span>
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
                        <div class="float-sm-right">
                            <a class="btn btn-danger btn-sm delete_role" id="multidel_act" >
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                            <a class="btn btn-success btn-sm add_role" id="add_act" >
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        </div>
                        <br>
                        <br>
                        <div class="table-responsive">
                        <table id="daftar_pajak_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id Pajak</th>
                                    <th>Nama Pajak</th>
                                    <th>Deskripsi Pajak</th>
                                    <th>Nilai</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Diupdate</th>
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
                        <input type="hidden" id="tax_id" name="tax_id"/>
                          <div class="form-group">
                            <label for="tax_name">Nama Pajak</label>
                            <input type="text" name="tax_name" id="tax_name" class="form-control" placeholder="Masukkan nama pajak ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="tax_description">Deskripsi Pajak</label>
                            <input type="text" name="tax_description" id="tax_description" class="form-control" placeholder="Masukkan deskripsi pajak ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="tax_value">Nilai</label>
                            <input type="text" name="tax_value" id="tax_value" class="form-control" placeholder="Masukkan nilai pajak ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="tax_unit">Jenis Pajak</label>
                            <br>
                            <input type="checkbox" class="switch-slider" name="tax_unit" id="tax_unit" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Cash" data-off="Percent" data-width="90">
                          </div>
                          <div class="form-group">
                            <label for="tax_status">Status</label>
                            <br>
                            <input type="checkbox" class="switch-slider" name="tax_status" id="tax_status" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Publish" data-off="Draft" data-width="90">
                          </div>
                          <div class="form-group field-edit">
                            <label for="tax_created">Dibuat</label>
                            <input type="text" name="tax_created" id="tax_created" class="form-control" >
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="tax_updated">Diupdate</label>
                            <input type="text" name="tax_updated" id="tax_updated" class="form-control">
                            <small class="form-text text-muted"></small>
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