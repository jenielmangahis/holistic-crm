    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">

            <?php $ai = 1; ?>
            <?php foreach($slides as $slide) { ?>
                    <?php $ai == 1 ? $active = 'active' : $active = ''; ?>
                    <div class="item <?php echo $active; ?>">
                      <img src="<?php echo $slide->thumbnail; ?>" alt="" class="Slide Image">
                      <div class="container">
                        <div class="carousel-caption">
                          <?php echo $slide->title; ?>
                          <?php echo $slide->caption; ?>
                        </div>
                      </div>
                    </div>  
                    <?php $ai++; ?>
            <?php } ?>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->