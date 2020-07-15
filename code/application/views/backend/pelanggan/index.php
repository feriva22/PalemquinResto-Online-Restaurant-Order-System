<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-utensils bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi pelanggan</span>
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
                        <table id="pelanggan_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nama</th>
                                    <th>Nomor HP</th>
                                    <th>Email</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Username</th>
                                    <th>Password</th>
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
                        <input type="hidden" id="cst_id" name="cst_id"/>
                          <div class="form-group">
                            <label for="cst_name">Nama Pelanggan</label>
                            <input type="text" name="cst_name" id="cst_name" class="form-control" placeholder="Masukkan nama ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="cst_phone">Nomor HP</label>
                            <input type="text" name="cst_phone" id="cst_phone" class="form-control" placeholder="Masukkan nomor ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="cst_email">Email</label>
                            <input type="text" name="cst_email" id="cst_email" class="form-control" placeholder="Masukkan email ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="cst_birthday">Tanggal Lahir</label>
                            <input type="text" name="cst_birthday" id="cst_birthday" class="form-control" placeholder="Masukkan tanggal lahir ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="cst_gender">Jenis Kelamin</label>
                            <br>
                            <input type="checkbox" class="switch-slider" name="cst_gender" id="cst_gender" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Laki-laki" data-off="Perempuan" data-width="110">
                          </div>
                          <div class="form-group">
                            <label for="cst_address">Alamat</label>
                            <input type="text" name="cst_address" id="cst_address" class="form-control" placeholder="Masukkan alamat ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="cst_username">Username</label>
                            <input type="text" name="cst_username" id="cst_username" class="form-control" placeholder="Masukkan username ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="cst_password">Password</label>
                            <input type="text" name="cst_password" id="cst_password" class="form-control" placeholder="Masukkan password ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="cst_status">Status</label>
                            <br>
                            <input type="checkbox" class="switch-slider" name="cst_status" id="cst_status" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Aktif" data-off="Suspend" data-width="90">
                          </div>
                          <div class="form-group field-edit">
                            <label for="cst_created">Dibuat</label>
                            <div class="col-md-12 p-0">
                                    <div id="cst_created"></div>
                            </div>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="cst_updated">Diupdate</label>
                            <div class="col-md-12 p-0">
                                    <div id="cst_updated"></div>
                            </div>
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