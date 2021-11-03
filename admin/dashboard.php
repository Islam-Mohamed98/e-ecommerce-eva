<?php

    ob_start(); // Out Put Buffering Start

    session_start();

    if (isset($_SESSION['Username'])) {
            $pageTitle = 'DashBoard';

            $navbar="";

            include 'init.php';

            // Function To Get Latest Registered Members
            $numUsers = 5;
            $latestUser = getLatest ("*", "user", "client_ID", $numUsers); // Latest User Array

            // Function To Get Latest Registered products
            $numItems = 5;
            $latestItem = getLatest ("*", "client_products", "index_ID", $numItems); // Latest products Array

            // Start DashBoard Page?>


            <div class="dashboard-main" data-class="dashboard" style="margin-left:15%;padding:50px 16px;">
              <div class="home-stats">
                  <div class="container text-center">
                      <h1>DashBoard</h1>
                      <div class="row">
                          <div class="col-md-3">
                              <div class="stat st-members">
                                  <i class="fa fa-users"></i>
                                  <div class="info">
                                      Total Members
                                  <span><a href="members.php"><?php echo countItems('client_ID', 'user') ?></a></span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="stat st-pending">
                                  <i class="fa fa-user-plus"></i>
                                  <div class="info">
                                  TotalEmployee
                                  <span><a href="members.php?do=Manage&page=Pending"><?php echo countItems('E_ID', 'employee') ?></a></span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="stat st-items">
                                  <i class="fa fa-tag"></i>
                                  <div class="info">
                                      Total items
                                      <span><a href="items.php"><?php echo countItems('index_ID', 'client_products') ?></a></span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="stat st-comments">
                                  <i class="far fa-comment-alt"></i>
                                  <div class="info">
                                      Total Comments
                                      <span><a href="comments.php"><?php echo countItems('comment_ID', 'comment') ?></a></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>


            </div>
            <!-- End Nav -->



            <?php
            include $tpl . "footer.php";


    } else {

        header('location:index.php');

        exit();

    }
    ob_end_flush();
?>
