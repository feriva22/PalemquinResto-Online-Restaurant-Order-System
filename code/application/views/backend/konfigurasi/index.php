<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-sliders bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi menu tambahan</span>
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
            <div class="col-md-6" >
                <div class="card  sticky-sidebar">
                    <div class="card-header"><h3>Konfigurasi</h3></div>
                    <div class="card-body">
                        <form class="sample-form" id="config-form">
                            <div class="form-group">
                                <label for="invoiceend_default">Default masa berlaku invoice pertama (hari)</label>
                                <input type="text" name="invoiceend_default" value="<?php echo explode(" ",get_valuesetting('invoiceend_default'))[0];?>" 
                                id="invoiceend_default" class="form-control" placeholder="Masukkan total hari" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="invoiceend_finaldp">Default masa berlaku invoice akhir (hari)</label>
                                <input type="text" name="invoiceend_finaldp" value="<?php echo explode(" ",get_valuesetting('invoiceend_finaldp'))[0];?>" 
                                id="invoiceend_finaldp" class="form-control" placeholder="Masukkan total hari" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="reservationend_default">Default masa reservasi tempat (menit)</label>
                                <input type="text" name="reservationend_default" value="<?php echo explode(" ",get_valuesetting('reservationend_default'))[0];?>" 
                                id="reservationend_default" class="form-control" placeholder="Masukkan total menit" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="default_mindp">Default minim DP (persen)</label>
                                <input type="text" name="default_mindp" value="<?php echo explode(" ",get_valuesetting('default_mindp'))[0];?>" 
                                id="default_mindp" class="form-control" placeholder="Masukkan total dp" required>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="allowed_deliveryaddr">Daerah delivery yang diperbolehkan (Kosongi jika ingin menerima seluruh daerah)</label>
                                <input type="text" name="allowed_deliveryaddr" value="<?php echo get_valuesetting('allowed_deliveryaddr');?>" 
                                id="allowed_deliveryaddr" class="form-control" placeholder="Masukkan daerah(kota/jln)">
                                <small class="form-text text-muted"></small>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
