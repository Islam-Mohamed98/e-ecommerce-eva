<?php

    /*
    ==================================
    ==
        From Here You Can Edit items Page
    ==
    ==================================
    */

    ob_start(); // Out Put Buffering Start

    session_start();

    $pageTitle = 'Items';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';?>

        <div class="dashboard-main" data-class = "products" style="margin-left:15%;padding:50px 16px;">
        <?php
/////////////////////////////////////==[Manage]==///////////////////////////////////////


        if ($do == 'Manage') {

            // Get Items Data

            $stmt = $con->prepare("SELECT
                                        client_products.index_ID,
                                        client_products.product_image,
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
");

            // Execute The Data From SQL

            $stmt->execute();

            $items = $stmt->fetchAll();

        ?>

            <h1 class="text-center">Manage Items</h1>
                <div class="container">
                    <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Date</td>
                        <td>Member</td>
                        <td>Category</td>
                        <td>Image</td>
                    </tr>
                    <?php
                    $status1 = array(

                        '1' => 'New',
                        '2' => 'Like New',
                        '3' => 'Used',
                        '4' => 'Old'
                    );
                    foreach($items as $item) {
                        echo'<tr>';
                            echo'<td>' . $item['index_ID'] . '</td>';
                            echo'<td>' . $item['Product_Name'] . '</td>';
                            echo'<td>' . $item['Price'] . '</td>';
                            echo'<td>' . $item['Quantity'] . '</td>';
                            echo'<td>' . $item['date'] . '</td>';
                            echo'<td>' . $item['Client_Name'] . '</td>';
                            echo'<td>' . $item['Cat_Name'] . '</td>'; ?>

                            <td>
                              <img style="/*height: 150px*/ width: 150px;"class="card-img-top" src="..\uploads\product_images\<?php
                              if(isset($item['product_image'])){
                                echo $item['product_image'];
                              } else {
                                echo 'default-non.png';
                              }
                              ?>" />
                            </td>
<?php

                        echo'<tr>';
                    }

                    ?>
                    </table>
                    </div>
                    <a href="items.php?do=Add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Add New Item</a>
                </div>

        <?php

 /////////////////////////////////////==[Add]==///////////////////////////////////////


        }else if ($do =='Add'){ ?>

            <!-- Start Html -->

                <h1 class="text-center">Add New Product</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">

                      <!-- Start Name Filed -->
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Product Name</label>
                          <div class="col-sm-10 col-md-4">
                              <input
                                     type="text"
                                     name="name"
                                     class="form-control"
                                     required="required" />
                          </div>
                      </div>
                      <!-- End Name Filed -->

                      <!-- Start Price Filed -->
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Quantity</label>
                        <div class="col-sm-10 col-md-4">
                          <input
                          type="number"
                          name="quantity"
                          class="form-control"
                          required="required" />
                        </div>
                      </div>
                      <!-- End Price Filed -->

                      <!-- Start Price Filed -->
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-4">
                          <input
                          type="text"
                          name="price"
                          class="form-control"
                          required="required" />
                        </div>
                      </div>
                      <!-- End Price Filed -->

                      <!-- Start Members Filed -->
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Member</label>
                          <div class="col-sm-10 col-md-4">
                              <select class ="form-control" name="member">
                                  <option value ="0">...</option>
                                  <?php

                                      $stmt = $con->prepare("SELECT * FROM client ");
                                      $stmt->execute();
                                      $users = $stmt->fetchAll();
                                      foreach($users as $user) {
                                          echo'<option value ="' . $user['client_ID'].'">' . $user['name']. '</option>';
                                      }

                                  ?>
                              </select>
                          </div>
                      </div>
                      <!-- End Members Filed -->

                      <!-- Start Categories Filed -->
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Category</label>
                          <div class="col-sm-10 col-md-4">
                              <select class ="form-control" name="category">
                                  <option value ="0">...</option>
                                  <?php

                                      $stmt2 = $con->prepare("SELECT * FROM catagory ");
                                      $stmt2->execute();
                                      $cats = $stmt2->fetchAll();
                                      foreach($cats as $cat) {
                                          echo'<option value ="' . $cat['ID'].'">' . $cat['Name']. '</option>';
                                      }

                                  ?>
                              </select>
                          </div>
                      </div>
                      <!-- End Categories Filed -->


                      <!-- Start Description Filed -->
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Description</label>
                          <div class="col-sm-10 col-md-4">
                              <textarea type="text" name="description" class="form-control" rows="5" required="required">  </textarea>
                          </div>
                      </div>
                      <!-- End Description Filed -->


                      <!-- Start Submit Filed -->
                      <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10 col-md-4">
                              <input type="submit" value="Add Item" class="btn btn-sm btn-primary" />
                          </div>
                      </div>
                      <!-- End Submit Filed -->
                    </form>
                </div>

                <!-- End Html -->
        <?php



 /////////////////////////////////////==[Insert]==///////////////////////////////////////


        } else if ($do == 'Insert') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variables From The Form

                $itemName     = $_POST['name'];
                $quantity = $_POST['quantity'];
                $price        = $_POST['price'];
                $Member_ID    = $_POST['member'];
                $Category_ID  = $_POST['category'];
                $description  = $_POST['description'];


                // start form

                echo '<h1 class="text-center">Inseret Member</h1>';
                echo '<div class="container">';

                // Validate The Form

                $formErrors = array();

                if (empty($itemName)) {

                    $formErrors[] = 'Item Name Cant Be <strong>Empty</strong>';
                }

                if (empty($description)) {

                    $formErrors[] = 'Description Cant Be <strong>Empty</strong>';
                }

                if (empty($price)) {

                    $formErrors[] = 'Price Cant Be <strong>Empty</strong>';
                }


                if (strlen($Member_ID == 0)) {

                    $formErrors[] = 'You Must Choose <strong>Member</strong> Characters';
                }

                if (strlen($Category_ID == 0)) {

                    $formErrors[] = 'You Must Choose <strong>Category</strong> Characters';
                }


                foreach($formErrors as $errors) {

                    echo '<div class="alert alert-danger">' . $errors . '</div>' ;
                }

                // Check If There's No Errors Proceed The Update Opertation

                if (empty($formErrors)) {



                    // Insert UserInfo In DataBase

                    $stmt = $con->prepare("INSERT INTO
                                            products(name, cat_ID)
                                            VALUES(:zname, :zcatID)");
                    $stmt->execute(array(

                        'zname'             => $itemName,
                        'zcatID'            => $Category_ID

                    ));

                    $theMsg = '<div class="alert alert-success">' . $stmt->rowCount(). ' Recored Inserted</div>';

                    $stmt = $con->prepare("INSERT INTO
                                            client_products(client_ID, P_ID, Price, Quantity, date, description, Approve)
                                            VALUES(:zmemberID, LAST_INSERT_ID(), :zprice, :zquantity, now(), :zdescription, 1)");
                    $stmt->execute(array(

                        'zmemberID'         => $Member_ID,
                        'zprice'            => $price,
                        'zquantity'         => $quantity,
                        'zdescription'      => $description

                    ));

                    // Echo Sucess Message If Username Is Not Exist

                    $theMsg = '<div class="alert alert-success">' . $stmt->rowCount(). ' Recored Inserted</div>';

                    redirectFunction($theMsg, 'back');


                }

            } else {

                $errorMsg = '<div class="alert alert-danger">You Cant Open This Page Direct</div>';
                redirectFunction($errorMsg);
            }

            echo '</div>';


/////////////////////////////////////==[Edit]==///////////////////////////////////////


        } else if ($do == 'Edit') {

            // Check If GEt Request userid Numeric & Get The Intehar Value Of It

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT
                                        *
                                    FROM
                                        items
                                    WHERE
                                        item_ID = ?");


            // Execute Query

            $stmt->execute(array($itemid));

            // Fetch The Data

            $item = $stmt->fetch();

            // The Row Count

            $count = $stmt->rowCount();

            // If There is Such ID Show The Form

            if($count > 0) { ?>

                <!-- Start Html -->

                <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">

                        <!-- Start Name Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <input type="hidden" name="itemid" value="<?php echo $item['item_ID']?>" />
                            <div class="col-sm-10 col-md-4">
                                <input
                                       type="text"
                                       name="name"
                                       class="form-control"
                                       required="required"
                                       placeholder="Name Of The Item"
                                       value="<?php echo $item['Name'] ?>"/>
                            </div>
                        </div>
                        <!-- End Name Filed -->

                        <!-- Start Description Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                <input
                                       type="text"
                                       name="description"
                                       class="form-control"
                                       required="required"
                                       placeholder="Description Of The Item"
                                       value="<?php echo $item['Description'] ?>"/>
                            </div>
                        </div>
                        <!-- End Description Filed -->

                        <!-- Start Price Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-4">
                                <input
                                       type="text"
                                       name="price"
                                       class="form-control"
                                       required="required"
                                       placeholder="Price Of The Item"
                                       value="<?php echo $item['Price'] ?>"/>
                            </div>
                        </div>
                        <!-- End Price Filed -->

                        <!-- Start Countery_Made Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Countery</label>
                            <div class="col-sm-10 col-md-4">
                                <input
                                       type="text"
                                       name="countery-made"
                                       class="form-control"
                                       placeholder="Countery Of Made"
                                       value="<?php echo $item['Countery_Made'] ?>"/>
                            </div>
                        </div>
                        <!-- End Countery_Made Filed -->

                        <!-- Start Status Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-4">
                                <select class ="form-control" name="status">
                                    <option value ="0">...</option>
                                    <option value ="1" <?php if ($item['Status'] == 1){echo 'selected';} ?>>New</option>
                                    <option value ="2" <?php if ($item['Status'] == 2){echo 'selected';} ?>>Like New</option>
                                    <option value ="3" <?php if ($item['Status'] == 3){echo 'selected';} ?>>Used</option>
                                    <option value ="4" <?php if ($item['Status'] == 4){echo 'selected';} ?>>Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Filed -->

                        <!-- Start Members Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-md-4">
                                <select class ="form-control" name="member">
                                    <?php
                                        $stmt = $con->prepare("SELECT * FROM users ");
                                        $stmt->execute();
                                        $users = $stmt->fetchAll();
                                        foreach($users as $user) {
                                            echo'<option value ="' . $user['UserID'].'"';
                                            if ($item['Member_ID'] == $user['UserID']){echo 'selected';}
                                            echo'>' . $user['Username']. '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Members Filed -->

                        <!-- Start Categories Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10 col-md-4">
                                <select class ="form-control" name="category">
                                    <?php
                                        $stmt2 = $con->prepare("SELECT * FROM categories ");
                                        $stmt2->execute();
                                        $cats = $stmt2->fetchAll();
                                        foreach($cats as $cat) {
                                            echo'<option value ="' . $cat['ID'].'"';
                                            if ($item['Cat_ID'] == $cat['ID']){echo 'selected';}
                                            echo'>' . $cat['Name']. '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Start Submit Filed -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 col-md-4">
                                <input type="submit" value="Save Item" class="btn btn-sm btn-primary" />
                            </div>
                        </div>
                        <!-- End Submit Filed -->
                    </form>
                    <?php

                    // Get Data From SQL Except GroupID 1

                    $stmt = $con->prepare("SELECT
                                                comments.*, users.Username AS User_Name
                                          FROM
                                                comments

                                            INNER JOIN
                                                users
                                          ON
                                                users.UserID = comments.Member_ID
                                            WHERE Item_ID = ?");

                    // Execute The Data From SQL

                    $stmt->execute(array($itemid));

                    $rows = $stmt->fetchAll();



                    ?>

                    <h1 class="text-center">Manage [<?php echo $item['Name'] ?>] Comments</h1>
                            <div class="table-responsive">
                            <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>Comment</td>
                                <td>Date</td>
                                <td>Member</td>
                                <td>Control</td>
                            </tr>
                            <?php

                            foreach($rows as $row) {
                                echo'<tr>';
                                    echo'<td>' . $row['comment'] . '</td>';
                                    echo'<td>' . $row['Add_Date'] . '</td>';
                                    echo'<td>' . $row['User_Name'] . '</td>';
                                    echo'<td>
                                            <a href="comments.php?do=Edit&comid=' .$row['C_ID']. '"class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="comments.php?do=Delete&comid='.$row['C_ID'].'" class="btn btn-danger check"><i class="fas fa-times"></i>Delete</a>';
                                            if ($row['status'] == 0) {
                                            echo '<a href="comments.php?do=Activate&comid='.$row['C_ID'].'" class="btn btn-info activate"><i class="fas fa-times"></i>Activates</a>';
                                            }
                                    echo '</td>';
                                echo'<tr>';
                            }
                            ?>
                            </table>
                            </div>
                    </div>

                    <!-- End Html -->

<?php
            } else { // Else Show Error Message



                $theMsg = '<div class="alert alert-danger">' . $stmt->rowCount(). ' RThere Is No Such ID</div>';

                redirectFunction($theMsg);
            }


 /////////////////////////////////////==[update]==///////////////////////////////////////


        } else if ($do == 'Update'){

            echo '<h1 class="text-center">Update Item</h1>';
            echo '<div class="container">';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $id          = $_POST['itemid'];
                $itemName        = $_POST['name'];
                $description        = $_POST['description'];
                $price       = $_POST['price'];
                $counteryMade= $_POST['countery-made'];
                $status      = $_POST['status'];
                $Member_ID      = $_POST['member'];
                $Category_ID         = $_POST['category'];

                // Validate The Form

                $formErrors = array();

                if (empty($itemName)) {

                    $formErrors[] = 'Item Name Cant Be <strong>Empty</strong>';
                }

                if (empty($description)) {

                    $formErrors[] = 'Description Cant Be <strong>Empty</strong>';
                }

                if (empty($price)) {

                    $formErrors[] = 'Price Cant Be <strong>Empty</strong>';
                }

                if (empty($counteryMade)) {

                    $formErrors[] = ' Countery Made Cant Be <strong>Empty</strong>';
                }


                if (strlen($status == 0)) {

                    $formErrors[] = 'You Must Choose <strong>Status</strong> Characters';
                }

                if (strlen($Member_ID == 0)) {

                    $formErrors[] = 'You Must Choose <strong>Member</strong> Characters';
                }

                if (strlen($Category_ID == 0)) {

                    $formErrors[] = 'You Must Choose <strong>Category</strong> Characters';
                }


                foreach($formErrors as $errors) {

                    echo '<div class="alert alert-danger">' . $errors . '</div>' ;
                }

                // Check If There's No Errors Proceed The Update Opertation

                if (empty($formErrors)) {

                        // Update Data Base

                        $stmt = $con->prepare("UPDATE
                                                    items
                                              SET
                                                  Name = ?,
                                                  Description = ?,
                                                  Price = ?,
                                                  Countery_Made = ?,
                                                  Status = ?,
                                                  Member_ID = ?,
                                                  Cat_ID = ?
                                              WHERE
                                                item_ID = ?");

                        $stmt->execute(array($itemName, $description, $price, $counteryMade, $status, $Member_ID, $Category_ID, $id));

                        // Echo Sucess Message

                        $theMsg = '<div class="alert alert-success">' . $stmt->rowCount(). ' Recored Updated</div>';

                        redirectFunction($theMsg, 'back');

                }

            } else {


                $theMsg = '<div class="alert alert-danger">' . $stmt->rowCount(). ' You Cant Open This Page Direct</div>';

                redirectFunction($theMsg);
            }

            echo '</div>';


/////////////////////////////////////==[Delete]==///////////////////////////////////////


        } else if ($do == 'Delete') {

            echo '<h1 class="text-center">Delete Member</h1>';

            echo '<div class="container">';

            $id = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            $check = checkItem('item_ID', 'items', $id);

            if($check > 0){

            $stmt = $con->prepare("DELETE FROM items WHERE item_ID = ?");

            $stmt->execute(array($id));

             $theMsg = '<div class="alert alert-success"> ID '.$id.' Deleted</div>';

            redirectFunction($theMsg, 'back');

            } else {

            $theMsg = '<div class="alert alert-danger"> This Is ID is Not Exist</div>';

            redirectFunction($theMsg);

            }

            echo '</div>';



/////////////////////////////////////==[Activate]==///////////////////////////////////////


        } else if ($do == 'Approve') {

            echo '<h1 class="text-center">Activate Member</h1>';

            echo '<div class="container">';

            // Check If GET Request itemID Numeric & Get The Intehar Value Of It

            $id = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0 ;

            // Select All Data Depend On This ID


            $check = checkItem('item_ID', 'items', $id);

            // If There is Such ID Show The Form

            if ($check > 0) {

                $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID = ?");

                $stmt->execute(array($id));

                $theMsg = '<div class="alert alert-success"> ID '.$id.' Activated</div>';

                redirectFunction($theMsg, 'back');

                } else {

                $theMsg = '<div class="alert alert-danger"> This Is ID is Not Exist</div>';

                redirectFunction($theMsg);
            }

            echo '</div>';
        }
        echo '</div>';
/////////////////////////////////////////////////////////////////////////////////////////


        include $tpl . 'footer.php';

    } else {

        header('location: index.php');
        exit();
    }

ob_end_flush();

?>
