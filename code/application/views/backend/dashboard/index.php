<div class="main-content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Pemesanan Katering </h6>
                                <h2><?php echo $tot_catering;?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-truck"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Pemesanan Reservasi</h6>
                                <h2><?php echo $tot_reservasi;?></h2>
                            </div>
                            <div class="icon">
                                <i class="fas fas fa-concierge-bell"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Invoice Terbayar</h6>
                                <h2><?php echo $inv_paid;?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Transaksi Tertunda</h6>
                                <h2><?php echo $trs_wait;?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>

            
        </div> 
       
        </div>   
    </div>
</div>