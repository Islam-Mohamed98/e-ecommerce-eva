<?php

    /*
    ==================================
    ==
        From Here You Can Edit Comments
    ==
    ==================================
    */

    session_start();

    $pageTitle = 'Comments';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; ?>

        <div class="dashboard-main" data-class="comments" style="margin-left:15%;padding:50px 16px;">
        <?php
/////////////////////////////////////==[Manage]==///////////////////////////////////////

        if ($do == 'Manage') { // Manage Page


            // Get Data From SQL Except GroupID 1

            $stmt = $con->prepare("SELECT
                                        comment.*, products.name AS Product_Name, client.name AS Client_Name
                                  FROM
                                        comment

                                  INNER JOIN
                                        client
                                  ON
                                        client.Client_ID = comment.Client_ID
                                  INNER JOIN
                                        client_products
                                  ON
                                        comment.P_ID = client_products.index_ID
                                  INNER JOIN
                                        products
                                  ON
                                        products.P_ID = client_products.P_ID
                                    ");

            // Execute The Data From SQL

            $stmt->execute();

            $rows = $stmt->fetchAll();



        ?>

                <div class="container">
                  <h1 class="text-center">Manage Comments</h1>
                    <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Date</td>
                        <td>Product Name</td>
                        <td>Member</td>
                        <td>Control</td>
                    </tr>
                    <?php

                    foreach($rows as $row) {
                        echo'<tr>';
                            echo'<td>' . $row['comment_ID'] . '</td>';
                            echo'<td>' . $row['comment'] . '</td>';
                            echo'<td>' . $row['date'] . '</td>';
                            echo'<td>' . $row['Product_Name'] . '</td>';
                            echo'<td>' . $row['Client_Name'] . '</td>';
                            echo'<td>
                                    <a href="comments.php?do=Edit&comid=' .$row['comment_ID']. '"class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                    <a href="comments.php?do=Delete&comid='.$row['comment_ID'].'" class="btn btn-danger check"><i class="fas fa-times"></i>Delete</a>';
                            echo '</td>';
                        echo'<tr>';
                    }
                    ?>
                    </table>
                    </div>
                </div>


        <?php

/////////////////////////////////////==[Edit]==///////////////////////////////////////

        } else if ($do == 'Edit') {// Edit Page

            // Check If GEt Request userid Numeric & Get The Intehar Value Of It

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT
                                        *
                                    FROM
                                        comment
                                    WHERE
                                        comment_ID = ?");


            // Execute Query

            $stmt->execute(array($comid));

            // Fetch The Data

            $row = $stmt->fetch();

            // The Row Count

            $count = $stmt->rowCount();

            // If There is Such ID Show The Form

            if($count > 0) { ?>

                <!-- Start Html -->

                <div class="container">
                  <h1 class="text-center">Edit Comments</h1>
                    <form class="form-horizontal" action="?do=update" method="POST">
                        <input type="hidden" name="comid" value="<?php echo $row['comment_ID']?>" />
                        <!-- Start Comment Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-10 col-md-4">
                                <textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
                            </div>
                        </div>
                        <!-- End Comment Filed -->


                        <!-- Start Submit Filed -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 col-md-4">
                                <input type="submit" value="Save" class="btn btn-primary" />
                            </div>
                        </div>
                        <!-- End Submit Filed -->
                    </form>
                </div>

                <!-- End Html -->


<?php
            } else { // Else Show Error Message



                $theMsg = '<div class="alert alert-danger">' . $stmt->rowCount(). ' RThere Is No Such ID</div>';

                redirectFunction($theMsg);
            }
/////////////////////////////////////==[update]==///////////////////////////////////////

        } else if ($do == 'update'){

            echo '<div class="container">';
            echo '<h1 class="text-center">Update Comment</h1>';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $comid  = $_POST['comid'];
                $comment = $_POST['comment'];


                        // Update Data Base

                        $stmt = $con->prepare("UPDATE comment SET comment = ? WHERE comment_ID = ?");

                        $stmt->execute(array($comment, $comid));

                        // Echo Sucess Message

                        $theMsg = '<div class="alert alert-success">' . $stmt->rowCount(). ' Recored Updated</div>';

                        redirectFunction($theMsg, 'back');


            } else {


                $theMsg = '<div class="alert alert-danger">' . $stmt->rowCount(). ' You Cant Open This Page Direct</div>';

                redirectFunction($theMsg);
            }

            echo '</div>';

/////////////////////////////////////==[Delete]==///////////////////////////////////////
        } else if ($do == 'Delete') {

            echo '<div class="container">';
            echo '<h1 class="text-center">Delete item</h1>';

            // Check If GEt Request userid Numeric & Get The Intehar Value Of It

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

            // Select All Data Depend On This ID

             $check = checkItem('comment_ID', 'comment', $comid);

            // If There is Such ID Show The Form

            if($check > 0) {

                $stmt = $con->prepare("DELETE FROM comment WHERE comment_ID = :zid");

                $stmt->bindParam(':zid', $comid);

                $stmt->execute();

                $theMsg = '<div class="alert alert-success"> ID '.$comid.' Deleted</div>';

                redirectFunction($theMsg, 'back');

            } else {

                $theMsg = '<div class="alert alert-danger"> This Is ID is Not Exist</div>';

                redirectFunction($theMsg);
            }

            echo '</div>';

        }

        echo '</div>';
        include $tpl . 'footer.php';

    } else {

        header('location: index.php');
        exit();
    }
?>
