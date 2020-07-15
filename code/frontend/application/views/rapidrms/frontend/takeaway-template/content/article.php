    <div class="heading" style="background-image: url(<?php echo base_url();?>assets/rapidrms/img/clints-say-bg.jpg)">
        <h1>Info & Promo</h1>
      </div>
      <div class="news-events-blog">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
            <?php foreach($data['articles'] as $article):?>
              <div class="blog-list">
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                    <div class="blog-list-img">
                      <img class="" src="img/content/blog-post.jpg" alt="">
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-8">
                    <h5><a href="<?php echo base_url();?>article/view/<?php echo $article->art_slug;?>"><?php echo $article->art_name;?></a>
                    </h5>
                    <ul class="list-inline">
                      <li class="place"><i class="fa fa-user"></i>
                        <span class="bl-sort">by</span><?php echo $article->stf_name;?></li>
                      <li class="date"><i class="fa fa-calendar"></i><?php echo $article->art_created;?></li>
                    </ul>
                    <p class="bl-sort"><?php echo substr(strip_tags($article->art_content), 0, 50).'....';?></p>
                    <a href="<?php echo base_url();?>article/view/<?php echo $article->art_slug;?>">Baca selanjutnya</a>

                    <!--<div class="tag-list">
                      <p><i class="fa fa-tag"></i><a href="#">Meat</a>, <a href="#">Drinks</a>
                      </p>
                    </div>-->
                  </div>
                  <!--end .blog-details-->
                </div>
                <!--end .row-->
              </div>
              <!--end .blog-list -->
              <?php endforeach;?>

              <div class="view-style">
                <!-- pagination from ci -->
				<?php echo $data['pagination'];?>
              </div>
              <!-- end view-style -->
            </div>
            <!-- end .col-md-8 -->

            <div class="col-md-4">
              <div class="events-side-panel">
                <div class="search-keyword">
                  <input type="text" placeholder="Search">
                  <button type="submit" value=""><i class="fa fa-search"></i>
                  </button>
                </div>
                <!-- end .search-keyword -->
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

                <!-- end .widget -->
            
              </div>
              <!-- end .events-side-panel -->
            </div>
            <!-- end .col-md-4 -->
          </div>
          <!-- end .row -->
        </div>
        <!-- end .container -->
      </div>
      <!-- end .news-events -->