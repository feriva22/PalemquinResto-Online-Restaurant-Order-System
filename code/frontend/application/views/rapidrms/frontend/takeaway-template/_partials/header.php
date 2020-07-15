<header id="header">
			<div class="header-top-bar">
				<div class="container">
					<div class="row">
						<div class="col-md-5 col-sm-12 col-xs-12">
							<div class="header-login">
								<a href="<?php echo base_url();?>Menu">Order online</a>
								<a href="<?php echo base_url();?>auth">Login</a>	
							</div>
							<!-- end .header-login -->
							<!-- Header Social -->
							<ul class="header-social">
								<li><a href="index.html#"><i class="fa fa-facebook-square"></i></a>
								</li>
								<li><a href="index.html#"><i class="fa fa-twitter-square"></i></a>
								</li>
								<li><a href="index.html#"><i class="fa fa-google-plus-square"></i></a>
								</li>
								<li><a href="index.html#"><i class="fa fa-linkedin-square"></i></a>
								</li>
								<li><a href="index.html#"><i class="fa fa-pinterest-square"></i></a>
								</li>
							</ul>
						</div>
						<div class="col-md-7 col-sm-12 col-xs-12">
							<p class="call-us">
								Call Us: <a class="font" href="index.html#">+6285732699287</a>
								<span class="open-now"><i class="fa fa-check-square"></i>Buka pada 08.00-20.00 WIB</span>
							</p>
						</div>
					</div> <!-- end .row --> 
				</div> <!-- end .container -->
			</div>
			<!-- end .header-top-bar -->

			<div class="header-nav-bar">
				<nav class="navbar navbar-default" role="navigation">
					<div class="container">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="<?php echo base_url();?>">
								<img src="<?php echo base_url();?>assets/rapidrms/img/logo.png" alt="<?php echo SITE_NAME;?>">
							</a>
						</div>

						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="<?php echo base_url();?>">Beranda</a>
								</li>
								<li>
									<a href="<?php echo base_url();?>Menu">Menu</a>
								</li>
								<li>
									<a href="<?php echo base_url();?>Reservation">Reservasi</a>
								</li>
								<!--
								<li class="dropdown">
									<a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">News & Events <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="news-events.html">News & Events list</a></li>
										<li><a href="event-page.html">News & Events post</a></li> 
									</ul>
								</li>
								-->
								<li>
									<a href="<?php echo base_url();?>article">Info & Promo</a>
								</li>
								<!--<li><a href="contact-us.html">Tentang Kami</a>
								</li>-->
								<?php if($this->session->userdata('logged_in')):?>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown">Akun Anda<span class="caret"></span></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="<?php echo base_url();?>customer/">Profil</a></li>
											<li><a href="<?php echo base_url();?>auth/logout" onclick="signOut();return false;" >Logout</a></li> 
										</ul>
									</li>
								<?php else:?>
										<li><a href="<?php echo base_url();?>auth">Login/Register</a>
									</li>
								<?php endif;?>
							</ul>
						</div>
						<!-- /.navbar-collapse -->
					</div>
					<!-- /.container-fluid -->
				</nav>
			</div>
        </header>