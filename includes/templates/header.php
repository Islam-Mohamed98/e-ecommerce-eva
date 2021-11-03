<!DOCTYPE html>
<html>
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- FontAwsome -->
      <link rel="stylesheet" href="<?php echo $css; ?>all.css" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
      <!-- animate Css -->
      <link rel="stylesheet" href="<?php echo $css; ?>animate.min.css">
      <!-- Custom Css -->
      <link rel="stylesheet" href="<?php echo $css; ?>custom.css" />
      <!-- Page title -->
      <title><?php getTitle (); ?></title>
    </head>
    <body>

      <!-- Start Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light fixed-top">
      <a style="color: black;" class="navbar-brand" href="#">E V A</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <!--  Start Dropdown CLOTHES -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              CLOTHES
            </a>
            <!-- Start Droplist -->
            <ul class="drop-list clothes-nav">
              <div class="container-fluid">
              <div class="row">
                <!-- Start First Row -->
                <div class="col-md-auto ">
                  <li class="main-row">
                    <ul>
                      <div class="row">
                        <div class="col">
                          <ul class="subdrop-list clearfix">
                            <?php
                              foreach(getCat(1) as $cat) {
                                  echo '<li><a href="categories.php?pageid=' . $cat['ID'] .'&pagename=' . str_replace(' ', '-', $cat['Name']) .'&sectionid='.$cat['section_ID'].'">' . $cat['Name'] . '</a></li>';
                              }
                            ?>
                          </ul>
                        </div>
                      </div>
                    </ul>
                  </li>
                </div>
                <!-- End First Row -->

              </div>
            </div>
            </ul>
            <!-- End DropList -->
          </li>
          <!--  End Dropdown CLOTHES -->
          <!--  Start Dropdown MOBILE -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              MOBILE
            </a>
            <!-- Start Droplist -->
            <ul class="drop-list mobile-nav">
              <div class="container-fluid">
              <div class="row">
                <!-- Start First Row -->
                <div class="col-md-auto ">
                  <li class="main-row">
                    <ul>
                      <div class="row">
                        <div class="col">
                          <ul class="subdrop-list">
                            <?php
                              foreach(getCat(3) as $cat) {
                                  echo '<li><a href="categories.php?pageid=' . $cat['ID'] .'&pagename=' . str_replace(' ', '-', $cat['Name']) .'&sectionid='.$cat['section_ID'].'">' . $cat['Name'] . '</a></li>';
                              }
                            ?>
                          </ul>
                        </div>
                      </div>
                    </ul>
                  </li>
                </div>
                <!-- End First Row -->

              </div>
            </div>
            </ul>
            <!-- End DropList -->
          </li>
          <!--  End Dropdown MOBILE -->
          <!--  Start Dropdown vehicle -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Vehicle
            </a>
            <!-- Start Droplist -->
            <ul class="drop-list vehicle-nav">
              <div class="container-fluid">
              <div class="row">
                <!-- Start First Row -->
                <div class="col-md-auto ">
                  <li class="main-row">
                    <ul>
                      <div class="row">
                        <div class="col">
                          <ul class="subdrop-list">
                            <?php
                              foreach(getCat(6) as $cat) {
                                  echo '<li><a href="categories.php?pageid=' . $cat['ID'] .'&pagename=' . str_replace(' ', '-', $cat['Name']) .'&sectionid='.$cat['section_ID'].'">' . $cat['Name'] . '</a></li>';
                              }
                            ?>
                          </ul>
                        </div>
                      </div>
                    </ul>
                  </li>
                </div>
                <!-- End First Row -->

              </div>
            </div>
            </ul>
            <!-- End DropList -->
          </li>
          <!--  End Dropdown FURNETURE -->

          <li class="nav-item dropdown"></li>
          <li class="nav-item dropdown"></li>

          <!--  Start Dropdown SEARCH -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-search"></i>
                SEARCH
            </a>
          </li>
          <!--  End Dropdown SEARCH -->

          <!-- Start Card -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php
              $count='0';
              if(isset($_SESSION['musername'])) {
              $event = "SELECT cart.quantity, cart.price, client_products.product_image
              FROM cart
              INNER JOIN client_products ON client_products.index_ID = cart.index_ID
              WHERE cart.client_ID = ?;
              ";
              $count = sqlGlobal ($event,'fetchAll', $_SESSION['mid'], 'count');
              }
              ?>
              <i class="fas fa-luggage-cart"></i>
                CART<span style="background:#ec5f5f;" class="badge badge-secondary"><?php echo $count ?></span>
            </a>
            <?php
            if(isset($_SESSION['musername'])) {

              // Select All Data Depend On This ID



              if ($count > 0) { ?>
            <!-- Start Droplist -->
            <ul class="drop-list cart-nav">
              <div class="container-fluid">
                  <ul class="cart-ul">
                    <!-- Start Product -->

                    <?php

                        // Fetch The Data
                        $carts = sqlGlobal ($event,'fetchAll', $_SESSION['mid']);

                        foreach ($carts as $cart) { ?>

                          <!-- Start Product -->
                          <li><a href="#">
                            <div style="padding:5px 0;" class="row">
                            <div class="col-3">
                              <img class="img-fluid" src="uploads\product_images\<?php if(isset($cart['product_image'])){echo $cart['product_image'];} else {echo 'default-non.png';}?>"/>
                            </div>
                            <div class="col-8">
                              <p>1 x <?php echo $cart['quantity'] . " = $ " . $cart['price']?> </p>
                            </div>
                          </div>
                          </a></li>
                          <!-- End Product -->
                      <?php  }


                     ?>
                  </ul>
                  <a href="cart.php" class="btn">View Cart</a>
            </div>
            </ul>
          <?php
          }
        } ?>
            <!-- End DropList -->
          </li>
          <!-- End Card -->
          <!-- Start Login button / User Panel -->
          <li class="nav-item dropdown">

            <?php // Check User Login

            // if user already Logged In
            if (isset($_SESSION['musername'])) {
                $stmt = $con->prepare("SELECT user.avatar, client.balance FROM user
                  INNER JOIN client ON client.client_ID = user.client_ID
                  WHERE user.client_ID = ?");

                // Execute The Data From SQL

                $stmt->execute(array($_SESSION['mid']));

                $userAB = $stmt->fetch();
               ?>
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img style="width: 50px; margin-right: 5px;" class=" my-img-info img-thumbnail img-fluid" src="uploads\avatars\<?php
                    if(isset($userAB['avatar'])){
                      echo $userAB['avatar'];
                    } else {
                      echo 'default-non.png';
                    }
                    ?>" />
                     <?php echo $_SESSION['musername']?>
                  </a>
                  <ul class="drop-list">
                    <ul class="user-list">
                      <li><a href="profile.php">My Profile</a></li>
                      <li><a href="newadd.php">Create New Add</a></li>
                      <li><a href="profile.php#my-ads">My Items</a></li>
                      <li><a href="profile.php#my-orders">My Orders</a></li>
                      <li><a href="logout.php"> Log Out</a></li>
                    </ul>
                  </ul>

                <?php // Check User activation

                /*
                $userstatus = checkStatus($_SESSION['musername']);

                // if user Not Active
                if ($userstatus == 1){
                    echo' Your Email Need To Activate';
                }
                */
            // if user didnt Login
            } else {
                echo '<a class="nav-link log" href="login.php">Login</a>';
            }
            ?>
          </li>
          <!-- Start Login button / User Panel -->
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
<?php
    if (!isset($noNav2)) { ?>

    <!-- Start Infodiv -->
    <div class="infodiv">
      <div class="overlay-b"></div>
      <div class="container">
        <div class="row">
          <div class="col">
            <h5><?php getNavTitle (); ?></h5>
            <p>Lorem Ipsum is simply dummy text of the printing </p>
          </div>
          <div class="col">
            <h6>home / <?php getNavTitle (); ?> / <?php if(isset($_GET['pagename'])){echo str_replace('-', ' ', $_GET['pagename']);} ?></h6>
          </div>
        </div>
      </div>
    </div>
    <!-- End Infodiv -->
<?php
}
?>
