<?php
    ob_start();
    session_start();
    $navTitle= "Categories";
    include 'init.php';
    $cat_id = $_GET['pageid'];
    ?>





    <!-- Start Products-Shop -->
    <div class="products">
      <div class="container">
        <div class="row">
          <div class="col-3">
            <div class="left-nav">
              <!-- Start category -->
              <div class="category">
                <h6>CATEGORIES</h6>
                <?php
                foreach(getCat($_GET['sectionid']) as $cat) {
                    echo '<a style="letter-spacing: 0.1em;
    text-transform: capitalize;" href="categories.php?pageid=' . $cat['ID'] .'&pagename=' . str_replace(' ', '-', $cat['Name']) .'&sectionid='.$cat['section_ID'].'">' . $cat['Name'] . '</a>';
                }
                ?>
              </div>
              <!-- End category -->
              <!-- Start Top seller -->
              <?php
              $stmt = $con->prepare("SELECT sales, name, avatar FROM client  INNER JOIN user ON client.client_ID = user.client_ID ORDER BY sales DESC LIMIT 5");
              $stmt->execute();
              $topsellers = $stmt->fetchAll();
               ?>
              <div class="top-sale">
                <h6>TOP SELLER</h6>
                <?php foreach($topsellers as $topseller) {?>
                  <!-- Start User  -->
                  <div class="row">
                    <div style="position: relative; top: 10px;" class="col-4">
                      <img class="img-fluid img-thumbnail" src="uploads\avatars\<?php
                      if(isset($topseller['avatar'])){
                        echo $topseller['avatar'];
                      } else {
                        echo 'default-non.png';
                      }
                      ?>">
                    </div>
                    <div class="col-8">
                      <div class="user-info">
                        <a><?php echo $topseller['name'] ?></a>
                        <h6>Sold : <span class="badge badge-secondary"><?php echo $topseller['sales'] ?></span></h6>
                      </div>
                    </div>
                  </div>
                  <!-- End User -->
                <?php } ?>

              </div>
              <!-- End Top Saller -->

            </div>
          </div>
          <div class="col-8">
            <div class="products-container">
              <div class="row">

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
                                      WHERE catagory.ID = ? AND client_products.quantity > 0 ORDER BY client_products.index_ID DESC;
        ");

                // Execute The Data From SQL

                $stmt->execute(array($cat_id));

                $products = $stmt->fetchAll();

                    foreach($products as $product) { ?>

                        <!-- Start Product -->
                        <div class="col-4">
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
                        <?php if($product['Price'] < 2000 || $product['Price'] > 21000) { ?>
                          <span class="new">Sale</span>
                    <?php    } ?>

                        <span class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        </span>
                        <p class="card-text"><?php echo substr($product['description'], 0, 70); ?> ...</p>
                        <a href="items.php?itemid=<?php echo $product['index_ID']?>" class="btn">View</a>
                        </div>
                        </div>
                        </div>
                        <!-- End Product -->

                <?php    }
                ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Start Products-Shop -->




<?php include $tpl . "footer.php";
    ob_end_flush();
?>
