            <div class="page-wrap">
                <div class="app-sidebar colored">
                    <div class="sidebar-header">
                        <a class="header-brand" href="<?php echo base_url();?>backend/dashboard">
                            <span class="text">Sistem Restoran</span>
                        </a>
                        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                    </div>
                    
                    <div class="sidebar-content">
                        <div class="nav-container">
                            <nav id="main-menu-navigation" class="navigation-main">
                                <div class="nav-item active">
                                    <a href="<?php echo base_url();?>backend/dashboard"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                <div class="nav-lavel">Pemesanan</div>
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/pemesanan"><i class="fas fas fa-shopping-cart"></i><span>Pemesanan</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/invoice"><i class="fas fas fa-money-bill-wave-alt"></i><span>Invoice</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/transaksi"><i class="fas fas fa-search-dollar"></i><span>Transaksi</span></a>
                                </div>
                                <div class="nav-lavel">Manajemen Restoran</div>
                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)"><i class="fas fa-fw fa-utensils"></i><span>Menu</span></a>
                                    <div class="submenu-content" style="">
                                        <a href="<?php echo base_url();?>backend/kategori_menu" class="menu-item is-shown">Kategori Menu</a>
                                        <a href="<?php echo base_url();?>backend/menu" class="menu-item is-shown">Menu</a>
                                        <a href="<?php echo base_url();?>backend/menu_tambahan" class="menu-item is-shown">Menu Tambahan</a>
                                    </div>
                                </div>
                                <!--
                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)"><i class="fas fas fa-concierge-bell"></i><span>Reservasi</span> </a>
                                    <div class="submenu-content" style="">
                                        <a href="<?php echo base_url();?>backend/meja_reservasi" class="menu-item is-shown">Denah Meja</a>
                                        <a href="pages/widget-statistic.html" class="menu-item is-shown">Konfigurasi Reservasi</a>
                                    </div>
                                </div>
                                -->
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/meja_reservasi"><i class="fas fas fa-concierge-bell"></i><span>Reservasi</span></a>
                                </div>
                                <!--
                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)"><i class="fas fa-fw fa-gavel"></i><span>Pajak</span> </a>
                                    <div class="submenu-content" style="">
                                        <a href="<?php echo base_url();?>backend/daftar_pajak" class="menu-item is-shown">Daftar Pajak</a>
                                        <a href="pages/widget-statistic.html" class="menu-item is-shown">Konfigurasi Pajak</a>
                                    </div>
                                </div>-->
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/daftar_pajak"><i class="fas fa-fw fa-gavel"></i><span>Pajak</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/diskon"><i class="ik ik-tag"></i><span>Diskon</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/pelanggan"><i class="ik ik-user"></i><span>Pelanggan</span></a>
                                </div>  
                                
                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)"><i class="ik ik-file-text"></i><span>Laporan</span> </a>
                                    <div class="submenu-content" style="">
                                        <a href="<?php echo base_url();?>backend/laporan/penjualan" class="menu-item is-shown">Laporan Penjualan</a>
                                        <!--<a href="<?php echo base_url();?>backend/laporan/pelanggan" class="menu-item is-shown">Laporan Pelanggan</a>-->
                                    </div>
                                </div>     
                                <div class="nav-lavel">System</div>
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/payment_gateway"><i class="fas fa-hand-holding-usd"></i><span>Payment Gateway</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/artikel"><i class="ik ik-globe"></i><span>Artikel</span></a>
                                </div>       
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/manajemen_staff"><i class="ik ik-users"></i><span>Manajemen Staff</span></a>
                                </div>  
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/konfigurasi"><i class="ik ik-sliders"></i><span>Konfigurasi</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/login/logout"><i class="ik ik-log-out"></i><span>Logout</span></a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>