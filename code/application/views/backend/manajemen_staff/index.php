<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-utensils bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi manajemen staff</span>
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
                        <table id="manajemen_staff_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Group</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Terakhir Login</th>
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
                        <input type="hidden" id="stf_id" name="stf_id"/>
                          <div class="form-group">
                            <label for="stf_group">Group Staff</label>
                            <select class="form-control" name="stf_group" id="stf_group">
                              <option value="">Silahkan pilih</option>
                              <?php foreach($data_group as $row){ ?>
                                  <option value="<?php echo $row->sdg_id; ?>"><?php echo $row->sdg_name; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="stf_name">Nama Staff</label>
                            <input type="text" id="stf_name" name="stf_name" class="form-control" placeholder="Masukkan nama ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group ">
                            <label for="stf_username">Username Staff</label>
                            <input type="text" id="stf_username" name="stf_username" class="form-control" placeholder="Masukkan Username ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="stf_email">Email Staff</label>
                            <input type="email" id="stf_email" name="stf_email" class="form-control" placeholder="Masukkan email ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="stf_password">Password Staff</label>
                            <input type="password" id="stf_password" name="stf_password" class="form-control" placeholder="Masukkan password">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="stf_lastlogin">Terakhir Login</label>
                            <div class="col-md-12 p-0">
                                    <div id="stf_lastlogin"></div>
                            </div>
                            <!--<input type="text" id="stf_lastlogin" name="stf_lastlogin" class="form-control" >-->
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="stf_status">Status</label>
                            <br>
                            <input type="checkbox" id="stf_status" class="switch-slider" name="stf_status" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Aktif" data-off="Suspend" data-width="90">
                          </div>
                          <div class="form-group field-edit">
                            <label for="stf_created">Dibuat</label>
                            <div class="col-md-12 p-0">
                                    <div id="stf_created"></div>
                            </div>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="stf_updated">Diupdate</label>
                            <div class="col-md-12 p-0">
                                    <div id="stf_updated"></div>
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