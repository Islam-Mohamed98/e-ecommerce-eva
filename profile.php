<?php
    ob_start();

    session_start();

    $pageTitle = 'Profile';

    $navTitle = "Profile";

    include 'init.php';

    if (isset($_SESSION['musername'])) {

    $getUser = $con->prepare('SELECT user.*, client.* FROM client INNER JOIN user ON client.client_ID = user.client_ID WHERE username = ?');

    $getUser->execute(array($sessionUser));

    $info = $getUser->fetch();


    $stmt = $con->prepare("SELECT A.name As Buyer, B.name As Seller ,products.name, orders.* , order_product.quantity, client_products.product_image, client_products.Price, client_products.description
                            FROM orders INNER JOIN client A ON orders.client_ID = A.client_ID AND A.client_ID = ?
                            INNER JOIN order_product ON orders.O_ID = order_product.O_ID
                            INNER JOIN client_products ON order_product.index_ID = client_products.index_ID
                            INNER JOIN products ON products.P_ID = client_products.P_ID
                            INNER JOIN client B ON client_products.client_ID = B.client_ID

");

    // Execute The Data From SQL

    $stmt->execute(array($_SESSION['mid']));

    $products = $stmt->fetchAll();



?>

<div class="profile-info">
<div class="container">

<h1 class="text-center">My Profile</h1>

    <!-- Start User Info -->
    <div class="information block">
        <div class="container">
            <div class="card">
                <div class="card-header">My Information</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fas fa-user-lock"></i>
                            <span>  Login Name</span>: <span><?php echo $info['username']?></span>
                        </li>
                        <li>
                            <i class="far fa-envelope-open"></i>
                            <span> Email</span>: <span><?php echo $info['Email']?></span>
                        </li>
                        <li>
                            <i class="far fa-address-book"></i>
                            <span> FullName</span>: <span><?php echo $info['name']?></span>
                        </li>
                        <li>
                            <i class="far fa-clock"></i>
                            <span> Date</span>: <span><?php echo $info['Date']?></span>
                        </li>
                        <li>
                            <i class="fas fa-coins"></i>
                            <span> balance</span>: <span><?php echo $info['balance']?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End User Info -->

    <!-- Start My Orders -->
    <div id="my-orders" class="my-orders block">
        <div class="container">
            <div class="card product-card">
              <div class="card-header">My Orders</div>
                <div class="card-body" style="padding: 60px;">
                  <?php
                    // $stmt = $con->prepare("");
                   ?>
                <div class="row">
                  <?php
                  // Count Orders
                  $stmt = $con->prepare("SELECT *, IF(orders.E_ID IS NULL , 'Employee Not Exist Yet', (SELECT employee.name FROM employee WHERE employee.E_ID = orders.E_ID)) As Employee FROM orders WHERE client_ID = ? ORDER BY O_ID DESC");
                  $stmt->execute(array($_SESSION['mid']));
                  $orders = $stmt->fetchAll();

                  foreach ($orders as $order) { ?>

                  <!-- Start Order -->
                  <div class="card mb-3" style="width: 100%;padding: 10px;height: 450px; overflow:auto;box-shadow: -2px 2px 4px 0px rgba(0, 0, 0, 0.05), 4px 9px 20px 0 rgba(60, 59, 59, 0.1);">
                    <div class="row no-gutters">
                      <div class="col-md-4">
                        <div id="carouselExampleControls<?php echo $order['O_ID'] ?>" class="carousel slide" style="top: 50%;transform: translateY(-50%);" data-ride="carousel">

                        <div id="order-carousel" class="carousel-inner">
                        <?php
                          $stmt = $con->prepare("SELECT
                                                      client_products.product_image,
                                                      client_products.index_ID,
                                                      products.name AS Product_Name,
                                                      client_products.Price,
                                                      client_products.description
                                                FROM client_products
                                                INNER JOIN products ON products.P_ID = client_products.P_ID
                                                INNER JOIN order_product ON order_product.index_ID = client_products.index_ID
                                                INNER JOIN orders ON orders.O_ID = order_product.O_ID
                                                WHERE orders.O_ID = ?;
                  ");

                          // Execute The Data From SQL

                          $stmt->execute(array($order['O_ID']));

                          $products1 = $stmt->fetchAll();

                           foreach($products1 as $product1) { ?>
                              <!-- Start Product -->
                              <div class="carousel-item" style="padding: 0 50px;">
                              <div class="card product-card">
                              <img style="/*height: 150px*/;"class="card-img-top" src="uploads\product_images\<?php
                              if(isset($product1['product_image'])){
                                echo $product1['product_image'];
                              } else {
                                echo 'default-non.png';
                              }
                              ?>" alt="Card image" style="width:100%">
                              <div class="card-body">
                              <h6 class="card-title"><?php echo substr($product1['Product_Name'], 0, 12); ?> <span class="badge badge-danger">hot</span> <span class="badge badge-info">topsale</span></h6>
                              <span class="price">$<?php echo $product1['Price'] ?></span>
                              <?php if($product1['Price'] < 2000 || $product1['Price'] > 21000) { ?>
                                <span class="new">Sale</span>
                          <?php    } ?>

                              <span class="star">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="far fa-star"></i>
                              <i class="far fa-star"></i>
                              </span>
                              <p class="card-text"><?php echo substr($product1['description'], 0, 70); ?> ...</p>
                              <a href="items.php?itemid=<?php echo $product1['index_ID']?>" class="btn">View</a>
                              </div>
                              </div>
                              </div>
                              <!-- End Product -->

                      <?php    }
                      ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls<?php echo $order['O_ID'] ?>" role="button" data-slide="prev">
                          <span style="color:black;"class="" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls<?php echo $order['O_ID'] ?>" role="button" data-slide="next">
                          <span style="color:black;" class="" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title">Order ID  <span style="color: gray;font-size: 20px;">#<?php echo $order['O_ID']?></span></h5>
                          <p style="display:inline-block;position: absolute; top: 0; right:0;"class="card-text"><small class="text-muted"><i style="margin-right: 5px;font-size: 10px;"class="far fa-clock"></i><?php echo $order['Date'] ?></small></p>

                          <ul class="list-group list-group-flush">
                            <li class="list-group-item">State:
                              <?php
                              if($order['order_state'] == 3 ) {
                                echo '<span class="badge badge-warning">Waiting For Employee</span>';
                              } elseif($order['order_state'] == 2 ) {
                                echo '<span class="badge badge-info">Order in Process</span>';
                              } else {
                                echo '<span class="badge badge-success">Done</span>';
                              }
                               ?>

                            </li>
                            <li class="list-group-item">Employee: <span style="font-size: 14px;margin-left: 10px;"><?php echo $order['Employee'] ?></span></li>
                            <li class="list-group-item">TotalPrice : <span style="font-size: 14px;margin-left: 10px;">$ <?php echo $order['totalprice']?></span></li>
                          </ul>
                          <h6 class="card-subtitle mb-2 text-muted" style="margin: 14px 20px;">Products :</h6>
                          <?php
                          $stmt = $con->prepare("SELECT  products.name AS Product_Name, order_product.Quantity
                          FROM client_products
                          INNER JOIN products ON products.P_ID = client_products.P_ID
                          INNER JOIN order_product ON order_product.index_ID = client_products.index_ID
                          INNER JOIN orders ON orders.O_ID = order_product.O_ID WHERE orders.O_ID = ?;
                  ");
                          // Execute The Data From SQL

                          $stmt->execute(array($order['O_ID']));

                          $products2 = $stmt->fetchAll();

                          foreach ($products2 as $product2) { ?>
                            <button type="button" class="btn cart-btn"><?php echo $product2['Product_Name'] ?> <span class="badge badge-light"><?php echo $product2['Quantity'] ?></span></button>
                        <?php  }
                           ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Order -->
                <?php }
                 ?>

                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End My Orders -->

    <!-- Start My Advertisments -->
    <div id="my-ads" class="my-ads block">
        <div class="container">
            <div class="card product-card">
              <div class="card-header">My Advertisments</div>
                <div class="card-body">
                  <?php

                  $stmt = $con->prepare("SELECT
                                              client_products.*,
                                              products.name AS Product_Name,
                                              client_products.Price,
                                              client_products.Quantity,
                                              client_products.date,
                                              client_products.Approve,
                                              client.name As Client_Name,
                                              catagory.name As Cat_Name
                                        FROM client_products
                                        INNER JOIN products ON products.P_ID = client_products.P_ID
                                        INNER JOIN client ON client.client_ID = client_products.client_ID
                                        INNER JOIN catagory ON products.cat_ID = catagory.ID
                                        WHERE client.client_ID = ?
          ");

                  // Execute The Data From SQL

                  $stmt->execute(array($_SESSION['mid']));
                  $products = $stmt->fetchAll();
                  $count=$stmt->rowCount();

                  //if there is Adv
                  if($count == 0) {
                    echo '<h6 class="card-subtitle mb-2 text-muted">No Advertisments To Show </h6>';

                  } else {
                      echo '<div class="row">';
                      foreach($products as $product) { ?>

                          <!-- Start Product -->
                          <div class="col-2">
                          <div class="card product-card">
                            <img style="/*height: 150px*/;"class="card-img-top" src="uploads\product_images\<?php
                            if(isset($product['product_image'])){
                              echo $product['product_image'];
                            } else {
                              echo 'default-non.png';
                            }
                            ?>" alt="Card image" style="width:100%">
                          <div class="card-body">
                          <h6 class="card-title"><?php echo substr($product['Product_Name'], 0, 12); ?> <span class="badge badge-danger">hot</span> <span class="badge badge-info">topsale</span></h6>
                          <span class="price">$<?php echo $product['Price'] ?></span>
                          <span class="star">
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="far fa-star"></i>
                          <i class="far fa-star"></i>
                          </span>
                          <p class="card-text"><?php echo substr($product['description'], 0, 50); ?> ...</p>
                          <a href="items.php?itemid=<?php echo $product['index_ID']?>" class="btn">View</a>
                          </div>
                          </div>
                          </div>
                          <!-- End Product -->

                  <?php    }

                  echo '</div>';
                  ?>

              <?php    }
              ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End my Advertisments -->


    <!-- Start My Comments -->
    <div class="my-comments block">
        <div class="container">
            <div class="card card-primary">
                <div class="card-header">Latest-Comments</div>
                <div class="card-body">
                <?php
                // Get Data From SQL Except GroupID 1

                $event ="SELECT * FROM comment WHERE client_ID = ?";

                // Execute The Data From SQL

                $test = $info['client_ID'];

                $comments = sqlGlobal ($event, 'fetchall', $test);

                if (! empty($comments)) {

                    foreach ($comments as $comment) { ?>

                      <div class="card">
                        <div class="card-body">
                          <blockquote class="blockquote mb-0">
                            <p><?php echo $comment['comment'] ?></p>
                            <footer class="blockquote-footer"><?php echo $comment['date'] ?></footer>
                          </blockquote>
                        </div>
                      </div>
<?php
                    }

                } else {

                    echo 'There Is No Comments TO Show';
                }

                ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End my Comments -->

  </div>
</div>

<?php
    } else {

        header('location:login.php');
        exit();
    }
    include $tpl . "footer.php";
    ob_end_flush();
?>
