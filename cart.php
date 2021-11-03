<?php
    ob_start();

    session_start();

    $pageTitle = 'Cart';

    $navTitle = "Cart";

    include 'init.php';

    if (isset($_SESSION['musername'])) {

      if(isset($_GET['do']) && $_GET['do'] == 'remove') {

        // Delect Cart Product


            $stmt = $con->prepare("DELETE from cart WHERE client_ID = ? AND index_ID = ?");

            $stmt->execute(array($_SESSION['mid'], $_GET['cartid']));
            header('Location: cart.php');
            exit();

      }

      // Make Order
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $Errors = array();

      $stmt = $con->prepare("SELECT * FROM cart WHERE client_ID = ?");
      $stmt->execute(array($_SESSION['mid']));
      $productsincart = $stmt->fetchAll();

      // Check If product quntity is Ok
      foreach ($productsincart as $productincart) {
        $stmt = $con->prepare("SELECT Quantity FROM client_products WHERE Index_ID = ? LIMIT 1");
        $stmt->execute(array($productincart['index_ID']));
        $test = $stmt->fetch();

        if($test['Quantity'] < $productincart['quantity']) {
          $Errors[] = 'Product Which ID =' .  $productincart['index_ID'] . 'Only Have' .  $productincart['quantity'] . ' Quantity' ;
          $prod[] = $productincart['index_ID'];
        }
      }

      if(empty($Errors)) {

        // ----------------------------------------------------[- Balance From Buyer]  ------------------------------- (1)
        $stmt = $con->prepare("UPDATE client SET balance = balance - (SELECT SUM(cart.price) FROM cart WHERE client_ID = ?) WHERE client_ID = ?");
        $stmt->execute(array($_SESSION['mid'], $_SESSION['mid']));

        // ----------------------------------------------------[Get All Products in Cart Of Buyer]  ------------------------------- (2)
        $stmt = $con->prepare("SELECT * FROM cart WHERE client_ID = ?");
        $stmt->execute(array($_SESSION['mid']));
        $productids = $stmt->fetchAll();

        // ----------------------------------------------------[Create Order]  ------------------------------- (3)
        $stmt = $con->prepare("INSERT INTO
                                orders(client_ID, date, E_ID, totalprice, order_state)
                                VALUES(:zclientid, now(), Null, :ztotalprice, 3)"); // 3 is not accpeted by Employee
        $stmt->execute(array(
            'zclientid'     => $_SESSION['mid'],
            'ztotalprice'   => $_POST['totalprice']
        ));

        foreach ($productids as $productid) {
          $stmt = $con->prepare("INSERT INTO order_product(O_ID, index_ID, quantity, price) VALUES(LAST_INSERT_ID(), :zproductid, :zquantity, :zprice)");
          $stmt->execute(array(

              'zproductid'     => $productid['index_ID'],
              'zquantity' => $productid['quantity'],
              'zprice'   => $productid['price']

          ));
        }

        // ----------------------------------------------------[- quntity of products from table Order_Products]  ------------------------------- (4)
        foreach ($productids as $productid) {
          // - Quntity of Products
          $stmt = $con->prepare("UPDATE client_products SET client_products.Quantity = client_products.Quantity - ? WHERE client_products.index_ID = ?");
          $stmt->execute(array($productid['quantity'], $productid['index_ID']));
        }

        // ----------------------------------------------------[Delect Product From cart]  ------------------------------- (5)
        $stmt = $con->prepare("DELETE from cart WHERE client_ID = :zuser");
        $stmt->bindParam(':zuser', $_SESSION['mid']);
        $stmt->execute();

        $theMsg = '<div class="alert alert-success"> Done </div>';

        redirectFunction($theMsg, 'back');

      }

      }

      ?>





<div class="cart-page">
  <div class="container">
    <h1 class="text-center "><?php echo $pageTitle ?></h1>
<?php
// Select All Data Depend On This ID
$event = "SELECT cart.index_ID, cart.quantity, cart.price, client_products.product_image,products.name, (SELECT SUM(cart.price) FROM cart)  As totalPrice
          FROM cart
          INNER JOIN client_products ON client_products.index_ID = cart.index_ID
          INNER JOIN products ON products.P_ID = client_products.P_ID
          WHERE cart.client_ID = ?;
          ";

$count = sqlGlobal ($event,'fetchAll', $_SESSION['mid'], 'count');

if ($count > 0) {

    // Fetch The Data
    $carts = sqlGlobal ($event,'fetchAll', $_SESSION['mid']);

    if(isset($cart) && !empty($cart)) { ?>
    <div class="row">
      <div class="col">

        <!-- Start Table -->
        <table class="table table-hover cart-table text-center">
          <thead>
            <tr>
              <th scope="col">Photo</th>
              <th scope="col">Name</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>

<?php
              foreach ($carts as $cart) { ?>

                <tr>
                  <td><img style="width:50px;"class="img-fluid" src="uploads\product_images\<?php if(isset($cart['product_image'])){echo $cart['product_image'];} else {echo 'default-non.png';}?>"/></td>
                  <td><?php echo $cart['name'] ?></td>
                  <?php
                  if(isset($prod)) {
                    if(in_array($cart['index_ID'], $prod)) {?>
                      <td class="table-danger"><?php echo $cart['quantity'] ?></td>
                  <?php  } else{ ?>
                    <td><?php echo $cart['quantity'] ?></td>
              <?php    }
                } else { ?>
                  <td><?php echo $cart['quantity'] ?></td>
                <?php  }
                   ?>
                  <td>$ <?php echo $cart['price'] ?></td>
                  <td><a href="?do=remove&cartid=<?php echo $cart['index_ID'] ?>"><i class="far fa-window-close"></i> Remove</a></td>
                </tr>

              <?php }
            } ?>
          </tbody>
        </table>
        <!-- End table -->

        <hr>

      </div>
    </div>
    <div class="row" style="padding: 50px 0;">
      <div class="col-3">
        <!-- Start Login Form -->
        <form class="cart-buy" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-group">
          <input type="text" name="country" class="form-control" placeholder="COUNTRY" required="required" autocomplete="off"/>
          <input type="hidden" name="totalprice" value="<?php echo  $cart['totalPrice'] ?>">
        </div>
        <div class="form-group">
          <input type="text" name="street" class="form-control"  placeholder="STREET" required="required" autocomplete="off"/>
        </div>
        <button id="buy-cart-btn" type="submit" class="btn cart-buy">Buy</button>
      </form>

      <!-- End Login Form -->
    </div>

      <div class="col-8">
            <p> Total Price  = $<span id="t-p"><?php echo $cart['totalPrice'] ?></span></p>
            <p> Your Balance  = $<span id="b-b"><?php
             global $userAB;
              echo $userAB['balance']
              ?></span></p>
            <hr>
            <p class="alert" role="alert"> Balance After = $ <span id="b-f"></span></p>
      </div>

    </div>
  <?php } else {
    echo '
    <div class="alert alert-warning" role="alert">
    <h4 class="alert-heading">Cart Empty!</h4>
    </div>
    ';
  }
  ?>
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
