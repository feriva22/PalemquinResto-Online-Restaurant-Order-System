            <!-- start #main-wrapper -->
			<?php if ($data['isReservation']) : ?>
			    <script>
					
			    </script>
			<?php endif; ?>
			<div class="container">
				<div class="row mt30">
					<div class="col-md-9 col-sm-12 col-md-push-3">
						<ul class="nav nav-tabs" >
							<li class="<?php if($data['menuType'] === 1) {echo 'active';}?> titleMenuTabNav" id="1"><a href="<?php echo base_url();?>Menu/" >Nasi Kotak</a>
							</li>
							<li class="<?php if($data['menuType'] === 2) {echo 'active';}?> titleMenuTabNav" id="2"><a href="<?php echo base_url();?>Menu/?menuType=2" >Aqiqah</a>
							</li>
							<li class="<?php if($data['menuType'] === 3) {echo 'active';}?> titleMenuTabNav" id="3"><a href="<?php echo base_url();?>Menu/?menuType=3" >Kambing Guling</a>
							</li>
							<li class="<?php if($data['menuType'] === 4) {echo 'active';}?> titleMenuTabNav" id="4"><a href="<?php echo base_url();?>Menu/?menuType=4" >Tumpeng</a>
							</li>
							<li class="<?php if($data['menuType'] === 5) {echo 'active';}?> titleMenuTabNav" id="5"><a href="<?php echo base_url();?>Menu/?menuType=5">Prasmanan</a>
							</li>
							<li class="<?php if($data['menuType'] === 6) {echo 'active';}?> titleMenuTabNav" id="6"><a href="<?php echo base_url();?>Menu/?menuType=6" >Restoran</a>
							</li>
						</ul>
						<?php if($data['isReservation']) : ?>
							<div class="menu-view-all">
						<?php else : ?>
							<div class="menu-view-all blurred">
						<?php endif;?>
						<div class="view-style dsn">
							<div class="list-grid-view">
								<button class="thumb-view"><i class="fa fa-list"></i></button>
								<button class="without-thumb"><i class="fa fa-align-justify"></i></button>
								<button class="grid-view"><i class="fa fa-th-list"></i></button> 
							</div>
							<!-- end .list-grid-view -->
							<!-- pagination from ci -->
							<?php echo $data['pagination'];?>
							<!-- end .page-list -->
						</div>
						<!-- end view-style -->
						<div class="tab-content">
							<div class="tab-pane fade in active">
								<div class="all-menu-details">
									<h5 class="titleMenuType"></h5>

									<?php foreach($data['dataMenu'] as $menu):?>
									<div class="item-list" data-idmenu="<?php echo $menu->mnu_id;?>">
										<div class="list-image">
											<?php if($menu->mnu_photo !== NULL):?>
											<img src="<?php echo $this->config->item('backend_url');?><?php echo $menu->mnu_photo;?>" alt="">
											<?php else:?>
												<img src="<?php echo $this->config->item('backend_url');?>assets/img/default/default-menu.png" alt="">
											<?php endif;?>
										</div>
										<div class="all-details">
											<div class="visible-option">
												<div class="details">
												<h6 class="nameOrder"><?php echo $menu->mnu_name;?>
												</h6>
												<p class="for-list"><?php echo $menu->mnu_desc;?></p>
											</div>
											<div class="price-option fl">
												<h5 class="priceOrder" style="text-align: center;margin: 0;padding: 30px 0;border-bottom: 1px solid #ccc;font-weight: bold;">Rp <?php echo $menu->mnu_price;?></h5>
												<button class="toggle">Opsi</button>
											</div>
											<!-- end .price-option-->
											<div class="qty-cart text-center">
												<h6>Kuantitas</h6>
												<form >
													<input type="number" class="qtyOrder" min=<?php echo $menu->mnu_minorder;?> value=<?php echo $menu->mnu_minorder;?>>
													<br>
													<button class="btnAddCart"><i class="fa fa-shopping-cart"></i>
													</button>
												</form>
											</div> <!-- end .qty-cart -->
										</div> <!-- end .vsible-option -->
										<div class="dropdown-option clearfix">
											<div class="dropdown-details">
													<h5>Menu tambahan (opsional)</h5>
													<div id="menuOptional-<?php echo $menu->mnu_id;?>">
													<?php foreach($menu->menu_additional as $menuOptional):?>
													<span class="checkbox-input">
														<input type="checkbox" name="menutambahan[]" id="menutambahan-<?php echo $menu->mnu_id;?>-<?php echo $menuOptional->mad_id;?>" name="Checkmenutambahan-<?php echo $menu->mnu_id;?>-<?php echo $menuOptional->mad_id;?>">
														<label for="menutambahan-<?php echo $menu->mnu_id;?>-<?php echo $menuOptional->mad_id;?>"><?php echo $menuOptional->mad_name;?></label>
													</span>
													<input type="text"  name="Quantitymenutambahan-<?php echo $menu->mnu_id;?>-<?php echo $menuOptional->mad_id;?>" placeholder="1" size="2" value="1">
													Rp. <?php echo $menuOptional->mad_price;?>/item</i>
													<?php endforeach;?>
													</div>
													<h6>Catatan tambahan</h6>
													<textarea id="noteMenu-<?php echo $menu->mnu_id;?>" placeholder="Tulis disini "></textarea>
													<!--<button class="btn btn-default-red btnAddCart">Konfirmasi</button>
													<a class="btn btn-default-black">Batal</a>-->
											</div>
											<!--end .dropdown-details-->
										</div>
										<!--end .dropdown-option-->
									</div>
									<!-- end .all-details -->
								</div>
								<!-- end .item-list -->
								<?php endforeach;?>
									
								</div> <!-- end .all menu details -->
								<?php echo $data['pagination'];?>
								<!-- end .pagination -->

							</div> <!-- end .tab-pane -->
						</div> <!-- end .tab-content -->
						
					</div>
					</div>
					<!--end main-grid layout-->

					<!-- Side-panel begin -->
					<div class="col-md-3 col-sm-12 col-xs-12 col-md-pull-9">
						<div class="side-panel">
							<!--<form class="default-form" >-->
								<h6 class="toggle-main-title">Side Panel</h6>
								<div class="sd-panel-heading" >
									<h5 class="toggle-title ">Keranjang saya</h5>
									<div class="slideToggle" >
										<ul class="list-unstyled" id="detail_cart">
											<!--load from server -->
										
									</div>
									<!--end .slide-toggle -->
								</div>
								<!-- end .sd-side-panel class -->

								<div class="search-keyword">
									<input type="text" placeholder="Search by keyword">
									<button type="submit" value=""><i class="fa fa-search"></i>
									</button>
								</div>
								<!-- end .search-keyword -->
								<!--
								<div class="category">
									<h5 class="">Category</h5>
									<div class="toggle-content">
										<h5 class="toggle-title">Fruits</h5>
										<ul class="list-unstyled">
											<li>
												<span class="checkbox-input">
													<input type="checkbox" id="fruits-1">
													<label for="fruits-1">Chicken</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="fruits-2">
													<label for="fruits-2">Duck</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="fruits-3">
													<label for="fruits-3">Turky</label>
												</span>
											</li>
										</ul>
									</div>
									
									<div class="toggle-content">
										<h5 class="toggle-title">Meat</h5>
										<ul class="list-unstyled">
											<li>
												<span class="checkbox-input">
													<input type="checkbox" id="meat-1">
													<label for="meat-1">Chicken</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="meat-2">
													<label for="meat-2">Duck</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="meat-3">
													<label for="meat-3">Turky</label>
												</span>
											</li>
										</ul>
									</div>

									<div class="toggle-content">
										<h5 class="toggle-title">Fish</h5>
										<ul class="list-unstyled">
											<li>
												<span class="checkbox-input">
													<input type="checkbox" id="fish-1">
													<label for="fish-1">Chicken</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="fish-2">
													<label for="fish-1">Duck</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="fish-3">
													<label for="fish-3">Turky</label>
												</span>
											</li>
										</ul>
									</div>

									<div class="toggle-content">
										<h5 class="toggle-title">poultry</h5>
										<ul class="list-unstyled">
											<li>
												<span class="checkbox-input">
													<input type="checkbox" id="poultry-1">
													<label for="poultry-1">Chicken</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="poultry-2">
													<label for="poultry-2">Duck</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="poultry-3">
													<label for="poultry-3">Turky</label>
												</span>
											</li>
										</ul>
									</div>

									<div class="toggle-content">
										<h5 class="toggle-title">Vegitables</h5>
										<ul class="list-unstyled">
											<li>
												<span class="checkbox-input">
													<input type="checkbox" id="vegitable-1">
													<label for="vegitable-1">Chicken</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="vegitable-2">
													<label for="vegitable-2">Duck</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="vegitable-3">
													<label for="vegitable-3">Turky</label>
												</span>
											</li>
										</ul>
									</div>

									<div class="toggle-content">
										<h5 class="toggle-title">Drinks</h5>
										<ul class="list-unstyled">
											<li>
												<span class="checkbox-input">
													<input type="checkbox" id="drinks-1">
													<label for="drinks-1">Chicken</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="drinks-2">
													<label for="drinks-2">Duck</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="drinks-3">
													<label for="drinks-3">Turky</label>
												</span>
											</li>
										</ul>
									</div>

									<div class="toggle-content">
										<h5 class="toggle-title">Desserts</h5>
										<ul class="list-unstyled">
											<li>
												<span class="checkbox-input">
													<input type="checkbox" id="desserts-1">
													<label for="desserts-1">Chicken</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="desserts-2">
													<label for="desserts-2">Duck</label>
												</span>
												<span class="checkbox-input">
													<input type="checkbox" id="desserts-3">
													<label for="desserts-3">Turky</label>
												</span>
											</li>
										</ul>
									</div>
								</div>
								-->
								<!--end .category-->
								<!--
								<div class="miscellaneous">
									<h5 class="">Miscellaneous</h5>
									<div class="radio">
										<span class="radio-input">
											<input type="radio" name="name-1" id="yes" checked>
											<label for="yes">Yes</label>
										</span>
										<span class="radio-input">
											<input type="radio" name="name-1" id="no">
											<label for="no">No</label>
										</span>
									</div>
									-->
									<!--end .radio-input -->
									<!--
										<span class="checkbox-input">
											<input type="checkbox" id="option-1" checked>
											<label for="option-1">Option1</label>
										</span>
										<span class="checkbox-input">
											<input type="checkbox" id="option-2">
											<label for="option-2">Option2</label>
										</span>
								 
									<div class="tag">
										<ul class="list-inline">
											<li><a href="menu(view-1).html#">Tag 1</a>
											</li>
											<li><a href="menu(view-1).html#">Tag 2</a>
											</li>
											<li><a href="menu(view-1).html#">Tag 3</a>
											</li>
										</ul>
									</div>
								</div>
								-->
								<!-- end .miscellaneous-->
								<!-- PRICE FILTER : begin -->
								<!--
								<div class="properties-search-filter">
									<div class="price-filter">
										<h5>Price Range</h5>
										<div class="">
											<div class="slider-range-container">
												<div class="slider-range" data-min="1" data-max="500" data-step="1" data-default-min="1" data-default-max="195" data-currency="$">
												</div>
												<div class="clearfix">
													<input type="text" class="range-from" value="$ 1">
													<input type="text" class="range-to" value="$ 500">
												</div>
											</div>
										</div>
									</div>
								</div>
								-->
								<!-- end .properties-search-filter -->

							<!--</form>-->
							<!-- end form -->
						</div>
						<!-- end side-panel -->
					</div>
					<!--end .col-md-3 -->
				</div>
				<!-- end .row -->
			</div>
			<!--end .container -->

			<!-- The modal for editcart -->
			<div class="modal fade" id="editCartModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-rowidmenu="">
				<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="modalLabel">Edit item cart</h4>
				</div>
				<div class="modal-body">
				<h3>Menu:</h3>
				
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-success btnSaveEditCart" >Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
				</div>
				</div>
			</div>
			<!-- end  #editCartModal -->
