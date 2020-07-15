<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-utensils bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi daftar menu</span>
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
                        <table id="menu_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id Menu</th>
                                    <th>Nama Menu</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori Menu</th>
                                    <th>Harga</th>
                                    <th>Foto Menu</th>
                                    <th>Minimal Order</th>
                                    <th>Varian Menu</th>
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
                        <input type="hidden" id="mnu_id" name="mnu_id"/>
                          <div class="form-group">
                            <label for="mnu_name">Nama Menu</label>
                            <input type="text" name="mnu_name" id="mnu_name" class="form-control" placeholder="Masukkan nama menu ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="mnu_desc">Deskripsi</label>
                            <input type="text" name="mnu_desc" id="mnu_desc" class="form-control" placeholder="Masukkan deksripsi menu ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="mnu_category">Kategori Menu</label>
                            <select class="form-control" name="mnu_category" id="mnu_category">
                              <option value="">Silahkan pilih</option>
                              <?php foreach($data_group as $row){ ?>
                                  <option value="<?php echo $row->mnc_id; ?>"><?php echo $row->mnc_name; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="mnu_photo">Foto</label>
                            <input type="file" multiple accept="image/x-png,image/gif,image/jpeg" title="Upload Image" id="mnu_photo" name="mnu_photo" />
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="form_preview">Preview</label>
                            <img id="form_preview" class="img-fluid" />
                          </div>
                          <div class="form-group">
                            <label for="mnu_minorder">Minim order</label>
                            <input type="text" name="mnu_minorder" id="mnu_minorder" class="form-control" placeholder="Masukkan Minim Order">
                            <small class="form-text text-muted"></small>
                          </div>
                          <!--
                          <div class="form-group">
                            <label for="check_varian">Apakah memiliki varian ?</label>
                            <br>
                            <button type="button" class="btn btn-secondary btn-sm" id="add_varian">Tambah varian</button>
                            <small class="form-text text-muted"></small>
                          </div>
                          -->
                          <div class="form-group">
                            <label for="check_varian">Menu tambahan </label>
                            <select class="selectpicker form-control" name="mnu_additional[]" id="mnu_additional" multiple data-live-search="true">
                              <?php foreach($data_menuadditional as $row){ ?>
                                  <option value="<?php echo $row->mad_id; ?>"><?php echo $row->mad_name; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="mnu_price">Harga</label>
                            <input type="text" name="mnu_price" id="mnu_price" class="form-control" placeholder="Masukkan harga ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="mnu_status">Status</label>
                            <br>
                            <input type="checkbox" class="switch-slider" name="mnu_status" id="mnu_status" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Publish" data-off="Draft" data-width="90">
                          </div>
                          <div class="form-group field-edit">
                            <label for="mnu_created">Dibuat</label>
                            <div class="col-md-12 p-0">
                                    <div id="mnu_created"></div>
                            </div>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="mnu_updated">Diupdate</label>
                            <div class="col-md-12 p-0">
                                    <div id="mnu_updated"></div>
                            </div>
                            <small class="form-text text-muted"></small>
                          </div>
                          <button type="submit" class="btn btn-primary float-right">Submit</button>
                          <button type="button" class="btn btn-light float-right mr-2" onclick="hide_detail()">Close</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="varian_modal" tabindex="-1" role="dialog" aria-labelledby="">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" >List Varian</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="mnu_id"/>
                        
                      
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>