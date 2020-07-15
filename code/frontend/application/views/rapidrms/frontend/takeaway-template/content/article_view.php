      <div class="heading" style="background-image: url(<?php echo base_url();?>assets/rapidrms/img/clints-say-bg.jpg)">
        <h1>Info & Promo</h1>
      </div>
      <!-- end .heading -->
      <div class="news-events-blog">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
            <?php if(isset($data['article'][0])):?>
              <div class="blog-post">
                <div class="row">
                <!--
                  <div class="col-md-12 col-sm-12">
                    <div class="blog-post-img">
                      <img class="" src="img/content/blog-post.jpg" alt="">
                    </div>
                  </div>-->
                  <div class="col-md-12 col-sm-12">
                    <h4><?php echo $data['article'][0]->art_name;?></h4>
                    <div class="about-author">
                      <ul class="list-inline">
                        <li class="place"><i class="fa fa-user"></i>
                          <span class="bl-sort">by</span><a href="#"><?php echo $data['article'][0]->stf_name;?></a>
                        </li>
                        <li class="date"><i class="fa fa-clock-o"></i><?php echo $data['article'][0]->art_created;?></li>
                      </ul>
                    </div>
                    <!-- end .about author -->
                    
                    <?php echo $data['article'][0]->art_content;?>   
                  </div>
                  <!--end grid-layout -->
                </div>
                <!--end .row-->
              </div>
              <!--end .blog-list -->
            <?php else:?>
                <h2>Artikel tidak ditemukan</h2>
                <a style="color: blue;" href="<?php echo base_url();?>article">Kembali ke daftar info & event</a>
            <?php endif;?>
            </div>
            <!-- end .col-md-8 -->

            <div class="col-md-4">
              <div class="events-side-panel">
                <div class="search-keyword">
                  <input type="text" placeholder="Search">
                  <button type="submit" value=""><i class="fa fa-search"></i>
                  </button>
                </div>

                <div class="widget">
                <h5>Info terbaru</h5>
                  <div class="blog-latest">
                  <?php foreach($data['new_article'] as $new):?>
                    <div class="row">
                      <div class="col-md-4 col-sm-3 col-xs-4">
                        <img class="" src="img/content/lt-blog-img.png" alt="">
                      </div>
                      <div class="col-md-8 col-sm-9 col-xs-8">
                        <h5><a href="#"><?php echo $new->art_name;?></a>
                        </h5>
                        <p class="bl-sort"><?php echo substr(strip_tags($new->art_content), 0, 50).'....';?></p>
                        <a href="<?php echo base_url();?>article/view/<?php echo $new->art_slug;?>">Baca Selanjutnya</a>
                      </div>
                      <!--end .blog-details-->
                    </div>
                    <!--end .row-->
                  </div>
                  <!--end .blog-list -->
                  <?php endforeach;?>

                </div>
                <!-- end .widget -->
                <!--
                <div class="tag">
                  <h5>Tags</h5>
                  <ul class="list-inline">
                    <li><a href="#">Tag 1</a>
                    </li>
                    <li><a href="#">Tag 2</a>
                    </li>
                    <li><a href="#">Tag 3</a>
                    </li>
                    <li><a href="#">Tag 4</a>
                    </li>
                    <li><a href="#">Tag 5</a>
                    </li>
                    <li><a href="#">Tag 6</a>
                    </li>
                    <li><a href="#">Tag 7</a>
                    </li>
                  </ul>
                </div>
              </div>
              end .events-side-panel -->
            </div>
            <!-- end .col-md-4 -->
          </div>
          <!-- end .row -->
        </div>
        <!-- end .container -->
      </div>
      <!-- end .news-events -->