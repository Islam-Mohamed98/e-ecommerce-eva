<?php

    ob_start(); // Out Put Buffering Start

    session_start();

    if (isset($_SESSION['Username'])) {
            $pageTitle = 'DashBoard';

            $navbar="";

            include 'init.php';
            $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
            ?>

            <div class="dashboard-main" data-class="dashboard" style="margin-left:15%;padding:50px 16px;">
              <?php

                if($do == 'Manage') {

                  $stmt = $con->prepare("SELECT orders.*, client.name
                                        FROM orders
                                        INNER JOIN client ON client.client_ID = orders.client_ID
                                        WHERE order_state = 3 ;");
                  $stmt->execute();
                  $orders = $stmt->fetchAll();?>

                    <div class="container">
                      <h1 class="text-center">un Accepted Orders</h1>
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

                                echo'<td><a href="?do=accept&orderid=' .$order['O_ID']. '"class="btn btn-info">Accept</a>';
                                echo '</td>';
                            echo'<tr>';
                        }
                        ?>
                        </table>
                        </div>
                    </div>

                  <?php
                } else if($do == 'accept'){

                  echo '<h1 class="text-center">Accept Order</h1>';

                  echo '<div class="container">';

                  // Check If GEt Request userid Numeric & Get The Intehar Value Of It

                  $orderid = isset($_GET['orderid']) && is_numeric($_GET['orderid']) ? intval($_GET['orderid']) : 0;

                  // Select All Data Depend On This ID
                  $stmt = $con->prepare("SELECT order_state FROM orders WHERE O_ID = ? LIMIT 1");
                  $stmt->execute(array($orderid));
                  $check1 = $stmt->fetch();



                  // If There is Such ID Show The Form

                  if(in_array(3, $check1)) {
                      $stmt = $con->prepare("UPDATE orders SET order_state = 2, E_ID = ? WHERE O_ID = ? AND O_ID = ?");
                      $stmt->execute(array($_SESSION['ID'], $orderid, $_GET['orderid']));
                      $theMsg = '<div class="alert alert-success"> ID '.$orderid.' Accepted</div>';
                      redirectFunction($theMsg, 'back', 0);


                  } else {

                      $theMsg = '<div class="alert alert-danger"> Other Employee Accepted This Order</div>';
                      redirectFunction($theMsg, 'back', 3);
                  }

                  echo '</div>';
                }

                   ?>

            </div>



            <?php
            include $tpl . "footer.php";


    } else {

        header('location:index.php');

        exit();

    }
    ob_end_flush();
?>
