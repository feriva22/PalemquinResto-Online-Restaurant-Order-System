<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk Laporan Penjualan</span>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h3>Laporan Penjualan</h3>
                        <span>Pilih paramater dibawah</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="row ml-2 mt-2 mr-2">
                            <div class="col-md-6">
                                <form method="GET" action="<?php echo base_url();?>backend/laporan/penjualan">
                                    <div class="form-row">
                                    <div class="form-group col-md-4 mb-0">
                                        <label for="invoice-code-filter">Tipe Laporan</label><br>
                                        <select class="form-control" name="type_report" id="type_report" >
                                        <option value="daily" <?php echo $type_report == 'daily' ? 'selected' : '';?>>Harian</option>
                                        <option value="monthly" <?php echo $type_report == 'monthly' ? 'selected' : '';?>>Bulanan</option>
                                        <option value="yearly" <?php echo $type_report == 'yearly' ? 'selected' : '';?>>Tahunan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 mb-0">
                                        <label for="start_date">Waktu Mulai</label><br>
                                        <div class="input-group date " id="start_date" data-target-input="nearest">
                                            <input type="text" value="<?php echo $start_date;?>" class="form-control datetimepicker-input" name="start_date" data-target="#start_date"/>
                                            <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-4 mb-0">
                                        <label for="end_date">Waktu Selesai</label><br>
                                        <div class="input-group date" id="end_date" data-target-input="nearest">
                                            <input type="text" value="<?php echo $end_date;?>" class="form-control datetimepicker-input" name="end_date" data-target="#end_date"/>
                                            <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                <button type="submit" class="btn btn-success btn-sm mb-2" id="process_report" >Proses</button>
                                </form>
                            </div>
                            
                            <div class="col-md-6">
                            <!--
                                <div class="float-sm-right">
                                    <a class="btn btn-secondary btn-sm " id="print_report" >
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                    <a class="btn btn-secondary btn-sm " id="download_report" >
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                                -->
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Total Penjualan</th>
                                        <th>Total Pajak</th>
                                        <th>Total Diskon</th>
                                        <th>Total Keuntungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $all_penjualan = 0;
                                    $all_tax = 0;
                                    $all_disc = 0;
                                    $all_net = 0;
                                    foreach($report as $row):
                                    ?>
                                    <tr>
                                        <td><?php echo $row->waktu;?></td>
                                        <td><?php echo number_rp($row->tot_penjualan);?></td>
                                        <td><?php echo number_rp($row->tot_tax);?></td>
                                        <td><?php echo number_rp($row->tot_discount);?></td>
                                        <td><?php echo number_rp($row->tot_net);?></td>
                                        <?php 
                                        $all_penjualan += $row->tot_penjualan;
                                        $all_tax += $row->tot_tax;
                                        $all_disc += $row->tot_discount;
                                        $all_net += $row->tot_net;
                                        ?>
                                    </tr>
                                    <?php endforeach;?>
                                    <!-- section total-->
                                    <tr>
                                        <td>Total:</td>
                                        <td><?php echo number_rp($all_penjualan);?></td>
                                        <td><?php echo number_rp($all_tax);?></td>
                                        <td><?php echo number_rp($all_disc);?></td>
                                        <td><?php echo number_rp($all_net);?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>                                        
        </div>
    </div>
</div>
