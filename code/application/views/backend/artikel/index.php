<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-utensils bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk manajemen artikel</span>
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
                        <table id="artikel_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Staff</th>
                                    <th>Nama</th>
                                    <th>Slug</th>
                                    <th>Konen</th>
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
                        <input type="hidden" id="art_id" name="art_id"/>
                        <div class="form-group field-edit">
                            <label for="art_staff">Staff</label>
                            <input type="text" id="art_staff" name="art_Staff" class="form-control" disabled>
                            <small class="form-text text-muted"></small>
                          </div>
                            <div class="form-group">
                            <label for="art_name">Nama Artikel</label>
                            <input type="text" id="art_name" name="art_name" class="form-control" placeholder="Masukkan nama ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="art_slug">Slug</label>
                            <input type="text" id="art_slug" name="art_slug" class="form-control" disabled>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group ">
                            <label for="art_content">Konten</label>
                            <textarea name="art_content" id="art_content" data-type="textarea" ></textarea>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="art_status">Status</label>
                            <br>
                            <input type="checkbox" id="art_status" class="switch-slider" name="art_status" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Publish" data-off="Draft" data-width="90">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="art_created">Dibuat</label>
                            <div class="col-md-12 p-0">
                                    <div id="art_created"></div>
                            </div>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="art_updated">Diupdate</label>
                            <div class="col-md-12 p-0">
                                    <div id="art_updated"></div>
                            </div>
                            <small class="form-text text-muted"></small>
                          </div>
                          <button type="submit" class="btn btn-primary float-right">Submit</button>
                          <button type="button" class="btn btn-light float-right mr-2" onclick="hide_detail('expand')">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>