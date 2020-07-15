<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-utensils bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi meja reservasi</span>
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
            <div class="col-md-12">
                <div class="card card-body">
                    <h5>Upload Map Baru</h5>
                    <p>upload gambar map untuk mengubah map restoran</p>
                    <form action="" method="post" id="map_upload_form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                        <input type="file" multiple="" accept="image/x-png,image/gif,image/jpeg" title="Upload Image" id="map_upload" name="map_upload">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                        <input type="submit" class="btn btn-primary btn-sm" value="Upload map baru">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-8 mx-auto">
                <div class="text-center">
                    <div class="row ">
                        <div class="col-12" id="canvas-wrapper" style="overflow:auto">
                            <canvas id="canvas" width="627" height="396"></canvas>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success btn-sm" id="saveMap">Simpan Map</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="modal fade" id="editTableId" tabindex="-1" role="dialog" aria-labelledby="testing" aria-hidden="true">
           <div class="modal-dialog modal-md" role="document">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title titleMenuType" id="edit-TableTitle">Edit Meja</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
               <div class="modal-body">
                 <p>Edit Nomor Meja dan Berapa Kapasitas yang dari meja dan minimal kursi yang harus diorder</p>
                 <form id="editTableForm" class="needs-validation"  novalidate>
                   <div class="form-row">
                     <div class="form-group col-md-12">
                       <input type="hidden" id="menu-idEdit" name="menu-id">
                       <label for="table-number" class="col-form-label">Nomor Meja:</label>
                       <input type="number" class="form-control" id="table-number" name="table-number" required>
                       <small id="table-numberError" style="display: none;" class="text-danger error">
                         Nomor meja sudah ada !
                       </small> 
                     </div>     
                   </div>
                   <div class="form-row">
                       <div class="form-group col-md-12">
                           <label for="table-capacity" class="col-form-label">Kapasitas:</label>
                           <input type="number" class="form-control" id="table-capacity" name="table-capacity" required>
                           <small id="table-capacityError" style="display: none;" class="text-danger error">
                             Kapasitas Kurang dari Minimal Orang !
                           </small> 
                         </div> 
                   </div>
                   <div class="form-row">
                       <div class="form-group col-md-12">
                           <label for="table-min" class="col-form-label">Minimal Orang:</label>
                           <input type="number" class="form-control" id="table-min" name="table-min" required>
                           <small id="table-minError" style="display: none;" class="text-danger error">
                             Minimal Orang Lebih dari Kapasitas Orang !
                           </small> 
                         </div> 
                   </div>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                 <button type="button" class="btn btn-danger" id="deleteTable">Hapus</button>
                 <input type="submit" class="btn btn-primary" value="Simpan">
               </div>
               </form>
             </div>
           </div>
         </div>


    </div>
</div>