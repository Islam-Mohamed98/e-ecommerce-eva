<?php
    ob_start();

    session_start();

    $pageTitle = 'Show Items';

    $navTitle = "Product";

    include 'init.php';




    // Check If GEt Request userid Numeric & Get The Intehar Value Of It
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    // Select All Data Depend On This ID
    $event = "SELECT
                client_products.*, products.name, catagory.Name As Catagory_Name, client.name As Member_Name
            FROM client_products
            INNER JOIN products ON products.P_ID = client_products.P_ID
            INNER JOIN client ON client.client_ID = client_products.client_ID
            INNER JOIN catagory ON catagory.ID = products.cat_ID
            WHERE
                index_ID = ? AND Approve = 1";



    $count = sqlGlobal ($event,'fetch', $itemid, 'count');

    if ($count > 0) {

        // Fetch The Data
        $item = sqlGlobal ($event,'fetch', $itemid);



?>


<!-- Start AddProduct -->
<div class="addproduct">
  <div class="container">
    <!-- Start Product Info -->
    <div class="row">
      <div class="col-5">
          <img class="img-fluid img-thumbnail" src="uploads\product_images\<?php if(isset($item['product_image'])){echo $item['product_image'];} else {echo 'default-non.png';}?>"/>
      </div>
      <div class="col-7">
        <div class="product-info">
          <div class="product-subdiv">
            <h4><?php echo $item['name']?></h4>
            <h4><span>Date</span>:<?php echo $item['date']?></h4>
            <?php
            global $test;
            if (isset($test)) {
              echo $test;
            }
             ?>
            <h4><span>Added By</span>:<a href="#"><?php echo $item['Member_Name']?></a></h4>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
          </div>
          <div class="product-subdiv">
            <p>
              <?php echo $item['description']?>
            </p>
          </div>
          <div class="product-subdiv">
            <div class="cat">
              <h6>Category: </h6><a href="categories.php?pageid=<?php echo $item['ID'] ?>&pagename=<?php echo $item['Catagory_Name']?>"><?php echo $item['Catagory_Name']?></a>
            </div>
          </div>
          <div class="product-subdiv">
            <h6>Price: $</h6><span><?php echo $item['Price']?><span>
          </div>
          <form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$item['index_ID']?>&do=buyproduct" method="POST">
          <?php
          if( isset($_SESSION['mid']) && $_SESSION['mid'] != $item['client_ID']) {
            echo '<input type="number" name="card_quantity" class="form-control product-num"  min="1" max="'. $item['Quantity'] .'"  value="1">';
            echo '<button type="submit" class="btn">ADD PRODUCT</button>';
          } elseif(!isset($_SESSION['mid'])) {
            echo '<a style="
                          color: white;
                          border: 1px solid #333333;
                          padding: 5px 26px;
                          float: left;
                          height: 30px;
                          display: inline-block;
                          font-size: 12px;
                          text-transform: uppercase;
                          letter-spacing: 0.2em;
                          background-color: #333333;
                          border-radius: 0;
                      "
            href="login.php" class="btn">Login To Buy Product</a>';
          }
           ?>

        </form>
        </div>
      </div>
    </div>
    <!-- End Product Info -->

    <!-- Start review Info -->
    <?php
            // Get Data From SQL Except GroupID 1

            $stmt = $con->prepare("SELECT
                                        comment.*, client.name As Client_Name, user.avatar
                                  FROM
                                        comment

                                    INNER JOIN
                                        client
                                  ON
                                        client.client_ID = comment.client_ID
                                    INNER JOIN
                                        user
                                  ON
                                        user.client_ID = client.client_ID

                                  WHERE P_ID = ? /* P_ID refer To Index_ID in table client_products*/
                                   ORDER BY
                                   comment_ID DESC");


            // Execute The Data From SQL

            $stmt->execute(array($itemid));

            $comments = $stmt->fetchAll();


    ?>

    <div class="row">
      <div class="col review">
        <h4>review</h4>

<?php  foreach($comments as $comment) { ?>
        <!-- Start User Reviews -->
        <div class="users-review">
          <div class="row">
            <div class="col-1">
              <img style="/*height: auto; width: 150px;*/"class="img-fluid" src="uploads\avatars\<?php
              if(isset($comment['avatar'])){
                echo $comment['avatar'];
              } else {
                echo 'default-non.png';
              }
              ?>" />
            </div>
            <div class="col">
              <span class="user"><?php echo $comment['Client_Name']?></span>
              <span class="date"><?php echo $comment['date']?></span>
              <span class="rate">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
              </span>
              <p>
                <?php echo $comment['comment']?>
              </p>
            </div>
          </div>
        </div>
        <hr>
    <?php } ?>
        <!-- End Users Reviews -->

        <?php if (isset($_SESSION['musername'])) { ?>
        <form class="review-form" action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$item['index_ID']?>&do=addcomment" method="POST">
          <div class="form-group">
            <label for="exampleFormControlTextarea1">ADD REVIEW</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="comment" rows="5"></textarea>
          </div>
          <button type="submit" class="btn">ADD</button>
        </form>

          <?php
          if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

            // check if post comming from Review Form
            if($_GET['do'] == 'addcomment') {

              $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
              $userid  = $_SESSION['mid'];
              $itemid  = $item['index_ID'];

              if (!empty($comment)) {
                  $stmt = $con->prepare("INSERT INTO
                                              comment
                                              (client_ID, comment, P_ID, date)
                                              VALUES
                                              (:zuserid, :zcomment, :zitemid, now() )");

                  $stmt->execute(array(

                      'zcomment'       => $comment,
                      'zitemid'       => $itemid,
                      'zuserid'       => $userid

                  ));

                if ($stmt)   {
                      echo '<div class="alert alert-success">Comment Added</div>';
                      header("location:" . $_SERVER['PHP_SELF'].'?itemid='.$item['index_ID']); // to not multi add comment
                  }

              }

            } elseif($_GET['do'] == 'buyproduct') { // check if post coming from Add Product Form


            $stmt = $con->prepare("SELECT cart.quantity FROM cart WHERE cart.client_ID = ? AND cart.index_ID = ?");
            $stmt->execute(array($_SESSION['mid'], $item['index_ID']));
            $count =  $stmt->rowCount();

            // Check If item Exist in Cart

            if ($count > 0 ) {

              $stmt = $con->prepare("UPDATE cart SET cart.quantity = cart.quantity + ? , cart.price = cart.price + ((SELECT client_products.Price FROM client_products WHERE client_products.index_ID = ? )*?) WHERE cart.client_ID = ? AND cart.index_ID = ?");
              $stmt->execute(array($_POST['card_quantity'], $item['index_ID'], $_POST['card_quantity'], $_SESSION['mid'],  $item['index_ID']));

            } else {
              $stmt = $con->prepare("INSERT into cart VALUES (? ,? , ?,(SELECT client_products.Price FROM client_products WHERE client_products.index_ID = ? ) * ?);");
              $stmt->execute(array($_SESSION['mid'], $item['index_ID'], $_POST['card_quantity'], $item['index_ID'], $_POST['card_quantity']));
            }

            if ($stmt)   {
              header('Location: cart.php');
              exit();
              }
            }
          }
        }
          ?>

      </div>
    </div>
    <!-- End review Info -->
  </div>
</div>
<!-- End AddProduct -->


<?php
} else { // Else of Count
        echo 'there is no such id';
    }
    include $tpl . "footer.php";
    ob_end_flush();
?>
