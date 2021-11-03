<?php

    /*
    ==================================
    ==
        From Here You Can Edit Members
    ==
    ==================================
    */

    session_start();

    $pageTitle = 'Members';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; ?>

        <div class="dashboard-main" data-class="my-orders" style="margin-left:15%;padding:50px 16px;">
        <?php
/////////////////////////////////////==[Manage]==///////////////////////////////////////

        if ($do == 'Manage') { // Manage Page


            // Get Data From SQL Except GroupID 1

            $stmt = $con->prepare("SELECT orders.*, client.name
                                  FROM orders
                                  INNER JOIN client ON client.client_ID = orders.client_ID
                                  WHERE E_ID = ? ;");
            $stmt->execute(array($_SESSION['ID']));
            $orders = $stmt->fetchAll();?>


            <div class="container">
              <h1 class="text-center">Un Done Orders</h1>
                <div class="table-responsive">
                <table class="main-table text-center table table-bordered mange-members">
                      <tr>
                          <td>#ID</td>
                          <td>Buyer</td>
                          <td>TotalPrice</td>
                          <td>Date</td>
                          <td>Control</td>
                      </tr>
                    <?php

                    foreach($orders as $order) {
                        echo'<tr>';
                            echo'<td>' . $order['O_ID'] . '</td>';
                            echo'<td>' . $order['name'] . '</td>';
                            echo'<td>' . '$   ' . $order['totalprice'] . '</td>';
                            echo'<td>' . $order['Date'] . '</td>';

                            echo'<td>
                            <a href="?do=view&orderid=' .$order['O_ID']. '"class="btn btn-dark">View</a>';
                            if ($order['order_state'] == 2) {
                              echo '<a style="margin-left: 5px;" href="?do=done&orderid=' .$order['O_ID']. '"class="btn btn-primary">Done</a>';
                            }
                            echo '</td>';
                        echo'<tr>';
                    }
                    ?>
                    </table>
                    </div>
                </div>


        <?php
 /////////////////////////////////////==[Add]==///////////////////////////////////////

}else if ($do =='view'){ // Add Members Page
  // Get Data From SQL Except GroupID 1

  $stmt = $con->prepare("SELECT * FROM orders WHERE E_ID = ? AND O_ID = ?");
  $stmt->execute(array($_SESSION['ID'], $_GET['orderid']));
  $orders = $stmt->fetchAll();?>

            <!-- Start Html -->

                <div class="container">
                  <h1 class="text-center ">Order View</h1>
              <?php
              // Select All Data Depend On This ID
              $event = "SELECT A.name As Buyer, B.name As Seller ,products.name, orders.totalprice, client_products.product_image, order_product.quantity, order_product.price
                        FROM orders
                        INNER JOIN client A ON orders.client_ID = A.client_ID
                        INNER JOIN order_product ON orders.O_ID = order_product.O_ID
                        INNER JOIN client_products ON order_product.index_ID = client_products.index_ID
                        INNER JOIN products ON products.P_ID = client_products.P_ID
                        INNER JOIN client B ON client_products.client_ID = B.client_ID
                        WHERE orders.O_ID = ?
                        ";

                $count = sqlGlobal ($event,'fetchAll', $_GET['orderid'], 'count');

                  // Fetch The Data
                  $orders = sqlGlobal ($event,'fetchAll',$_GET['orderid']);

                  if(isset($orders) && !empty($orders)) { ?>
                  <div class="row">
                    <div class="col">

                      <!-- Start Table -->
                      <table class="table table-hover cart-table text-center">
                        <thead>
                          <tr>
                            <th scope="col">Buyer</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Seller</th>
                          </tr>
                        </thead>
                        <tbody>

              <?php
                            $i = 0;
                            foreach ($orders as $order) { ?>

                              <tr>
                                <td><?php if ($i == 0 ){echo $order['Buyer'];} ?></td>
                                <td><img style="width:50px;"class="img-fluid" src="..\uploads\product_images\<?php if(isset($order['product_image'])){echo $order['product_image'];} else {echo 'default-non.png';}?>"/></td>
                                <td><?php echo $order['name'] ?></td>
                                <td><?php echo $order['quantity'] ?></td>
                                <td>$ <?php echo $order['price'] ?></td>
                                <td><?php echo $order['Seller'] ?></td>
                              </tr>

                            <?php
                            $i++;
                            }
                          } ?>
                        </tbody>
                      </table>
                      <!-- End table -->

                      <hr>

                    </div>
                  </div>
                </div>

                <!-- End Html -->
        <?php

/////////////////////////////////////==[Done]==///////////////////////////////////////

} else if ($do == 'done'){
            echo '<div class="container">';

            echo '<h1 class="text-center">Order Done</h1>';



                    $stmt2 = $con->prepare("SELECT * FROM orders WHERE O_ID = ? And order_state = 2 AND E_ID = ?");
                    $stmt2->execute(array($_GET['orderid'], $_SESSION['ID']));

                    $count = $stmt2->rowCount();


                    if ($count == 1) {

                        // Update Data Base
                        $stmt = $con->prepare("UPDATE orders SET order_state = 1 WHERE O_ID = ?");
                        $stmt->execute(array($_GET['orderid']));

                        // Get Index ID Of Products Where Order ID = ?
                        $stmt = $con->prepare("SELECT index_ID, price, Quantity FROM order_product WHERE O_ID = ?");
                        $stmt->execute(array($_GET['orderid']));
                        $productids = $stmt->fetchAll();

                        //Add Balance To Users
                        foreach ($productids as $productid) {

                          // Add Balance To Seller
                          $stmt = $con->prepare("UPDATE client SET balance = balance + ?, sales = sales + ? WHERE client_ID = (
                                                SELECT client_products.client_ID FROM client_products
                                                INNER JOIN order_product ON order_product.index_ID = client_products.index_ID
                                                INNER JOIN orders ON orders.O_ID = order_product.O_ID
                                                 WHERE order_product.index_ID = ? AND orders.O_ID = ?
                                                )");

                          $stmt->execute(array($productid['price'], $productid['Quantity'],$productid['index_ID'], $_GET['orderid']));
                          }

                          // Echo Sucess Message

                          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount(). ' Recored Updated</div>';

                          redirectFunction($theMsg, 'back', 0);


                    } else {

                        $theMsg = '<div class="alert alert-danger">This Order Not Exist</div>';

                        redirectFunction($theMsg, 'back');
                    }




            echo '</div>';

/////////////////////////////////////==[Delete]==///////////////////////////////////////
        } else if ($do == 'Delete') {

            echo '<h1 class="text-center">Delete Member</h1>';

            echo '<div class="container">';

            // Check If GEt Request userid Numeric & Get The Intehar Value Of It

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

            // Select All Data Depend On This ID

             $check = checkItem('client_ID', 'user', $userid);

            // If There is Such ID Show The Form

            if($check > 0) {

                $stmt = $con->prepare("DELETE from client , user using client INNER JOIN user WHERE user.client_ID = client.client_ID AND user.client_ID = :zuser");

                $stmt->bindParam(':zuser', $userid);

                $stmt->execute();

                $theMsg = '<div class="alert alert-success"> ID '.$userid.' Deleted</div>';

                redirectFunction($theMsg, 'back');

            } else {

                $theMsg = '<div class="alert alert-danger"> This Is ID is Not Exist</div>';

                redirectFunction($theMsg);
            }

            echo '</div>';

/////////////////////////////////////==[Activate]==///////////////////////////////////////

        } else if ($do == 'Activate') {

            echo '<h1 class="text-center">Activate Member</h1>';

            echo '<div class="container">';

            // Check If GEt Request userid Numeric & Get The Intehar Value Of It

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

            // Select All Data Depend On This ID

             $check = checkItem('client_ID', 'user', $userid);

            // If There is Such ID Show The Form

            if($check > 0) {

                $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE client_ID = ?");

                $stmt->execute(array($userid));

                $theMsg = '<div class="alert alert-success"> ID '.$userid.' Activated</div>';

                redirectFunction($theMsg, 'back');

            } else {

                $theMsg = '<div class="alert alert-danger">' . $stmt->rowCount(). ' This Is ID is Not Exist</div>';

                redirectFunction($theMsg);
            }

            echo '</div>';
        }
        echo '</div>'; // marged div

        include $tpl . 'footer.php';

    } else {

        header('location: index.php');
        exit();
    }
?>
