<?php

    ob_start();

    session_start();

    $pageTitle = 'HomePage';

    $noNav2=''; // Dont not include Nav2


    include 'init.php';?>

    <!-- Start background Video -->
    <!-- overlay -->
    <div class="overlay-bl"></div>
    <video autoplay muted loop id="myVideo">
      <source src="<?php echo $img ?>Walking - 21782.mp4" type="video/mp4">
    </video>
    <!-- End background Video -->

    <!-- Start Header -->
    <div class="header-sec">
      <div class="container">
        <div class="text-center">
          <h1 class="wow fadeInDown"><span class="logo-color">Eva</span><span class="logo-color2">Shop</span></h1>
            <p class="wow fadeInDown" data-wow-delay="0.5s">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop p
            </p>
        </div>
      </div>
    </div>
    <!-- End Header -->

    <!-- Start service -->
    <div class="service-sec">
      <!-- Start First Service -->
      <div class="container-fluid">
      <div class="row">
        <div class="col">
          <img  src="<?php echo $img ?>bar-bottles-commerce-2079438.jpg" class="img-fluid" >
        </div>
        <div class="col">
          <!-- Start Content -->
          <div class="content text-center">
            <h5 class="wow fadeInUp">
              Lorem Ipsum is simply dummy text of the printing and typesetting
            </h5>
            <p class="wow fadeInUp" data-wow-delay="0.5s">
              Marius auctor ex id urna faucibus. In maximus ligula semper metus lorem pellentesque mattis.Maecenas volutpat, diam enim sagittis quam, id porta quam. Lorem ipsum dolor sit amet, c-r adipiscing elit volutpat, accumsan ligula semper metus pellentesque mattis. Maecenas volutpat, diam enim. Donec vel ultricies dictum sem, eu aliquam.
            </p>
            <a class="wow fadeInUp" data-wow-delay="0.8s" href="#">VIEW</a>
          </div>
          <!-- End Content -->
        </div>
      </div>
      <!-- End First Service -->
      <!-- Start Second Service -->
      <div class="row">
        <div class="col">
          <!-- Start Content -->
          <div class="content text-center">
            <h5 class="wow fadeInUp">
              Lorem Ipsum is simply dummy text of the printing and typesetting
            </h5>
            <p class="wow fadeInUp" data-wow-delay="0.5s">
              Marius auctor ex id urna faucibus. In maximus ligula semper metus lorem pellentesque mattis.Maecenas volutpat, diam enim sagittis quam, id porta quam. Lorem ipsum dolor sit amet, c-r adipiscing elit volutpat, accumsan ligula semper metus pellentesque mattis. Maecenas volutpat, diam enim. Donec vel ultricies dictum sem, eu aliquam.
            </p>
            <a class="wow fadeInUp" data-wow-delay="0.8s" href="#">VIEW</a>
          </div>
          <!-- End Content -->
        </div>
        <div class="col">
          <img src="<?php echo $img ?>black-friday-brown-from-above-5956 (1).jpg" class="img-fluid">
        </div>
      </div>
      <!-- End Second Service -->
      </div>
    </div>
    <!-- End service -->

    <!-- Start What People Say -->
    <div class="people-rev">
      <div class="overlay-black"></div>
      <h4 class="text-center">What People Say ? </h4>
      <!-- Start Carousel-->
      <div class="bd-example">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="carousel-caption d-none d-md-block">
                <h5>First slide label</h5>
                <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
              </div>
            </div>
            <div class="carousel-item">
              <div class="carousel-caption d-none d-md-block">
                <h5>Second slide label</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
              </div>
            </div>
            <div class="carousel-item">
              <div class="carousel-caption d-none d-md-block">
                <h5>Third slide label</h5>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <!-- End Carousel -->
    </div>
    <!-- End What People Say -->



    <?php
    include $tpl . "footer.php";

    ob_end_flush();

?>
