<?php

    /*
    ==================================
    ==
        From Here You Can Edit Members
    ==
    ==================================
    */

    session_start();

    $pageTitle = 'Employee';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; ?>

        <div class="dashboard-main" data-class="employee" style="margin-left:15%;padding:50px 16px;">
        <?php
/////////////////////////////////////==[Manage]==///////////////////////////////////////

        if ($do == 'Manage') { // Manage Page

            // Get Data From SQL Except GroupID 1

            $stmt = $con->prepare("SELECT * FROM employee");

            // Execute The Data From SQL

            $stmt->execute();

            $rows = $stmt->fetchAll();



        ?>

                <div class="container">
                  <h1 class="text-center">Manage Employee</h1>
                    <div class="table-responsive">
                    <table class="main-table text-center table table-bordered mange-members">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Phone</td>
                        <td>E-Mail</td>
                        <td>Control</td>
                    </tr>
                    <?php

                    foreach($rows as $row) {
                        echo'<tr>';
                            echo'<td>' . $row['E_ID'] . '</td>';
                            echo'<td>' . $row['name'] . '</td>';
                            echo'<td>' . $row['phone'] . '</td>';
                            echo'<td>' . $row['E_mail'] . '</td>';
                            echo'<td>
                                    <a href="employee.php?do=Edit&empid=' .$row['E_ID']. '"class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                    <a href="employee.php?do=Delete&empid='.$row['E_ID'].'" class="btn btn-danger check"><i class="fas fa-times"></i>Delete</a>';
                            echo '</td>';
                        echo'<tr>';
                    }
                    ?>
                    </table>
                    </div>
                    <a href="employee.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Employee</a>
                </div>


        <?php
 /////////////////////////////////////==[Add]==///////////////////////////////////////

        }else if ($do =='Add'){ // Add Members Page

                ?>
            <!-- Start Html -->

                <div class="container">
                  <h1 class="text-center">Add New Employee</h1>
                    <form class="form-horizontal" action="?do=Insert" method="POST">

                        <!-- Start UserName Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Employee Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="employee-name"  class="form-control" autocomplete="off" required="required" />
                            </div>
                        </div>
                        <!-- End UserName Filed -->

                        <!-- Start UserName Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="username"  class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop" />
                            </div>
                        </div>
                        <!-- End UserName Filed -->

                        <!-- Start Password Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder=".Password Must be Hard & Complex" />
                                <i class="show-pass fa fa-eye "></i>
                            </div>
                        </div>
                        <!-- End Password Filed -->


                        <!-- Start Email Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email"  class="form-control" required="required" />
                            </div>
                        </div>
                        <!-- End Email Filed -->

                        <!-- Start Full-Name Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="phone"  class="form-control" required="required" />
                            </div>
                        </div>
                        <!-- End Full-Name Filed -->

                        <!-- Start Submit Filed -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 col-md-4">
                                <input type="submit" value="Add Employee" class="btn btn-primary" />
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

                // start form

                echo '<div class="container">';
                echo '<h1 class="text-center">Inseret Member</h1>';


                $employeeName = $_POST['employee-name'];
                $username = $_POST['username'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $hashpass = sha1($_POST['password']);


                // Validate The Form

                $formErrors = array();

                if (empty($username)) {

                    $formErrors[] = 'Username Cant Be <strong>Empty</strong>';
                }

                if (strlen($username) < 4) {

                    $formErrors[] = 'Username Cant Be Less Than <strong>4</strong> Characters';
                }

                if (strlen($username) > 20) {

                    $formErrors[] = 'Username Cant Be More Than <strong>20</strong> Characters';
                }

                if (empty($employeeName)) {

                    $formErrors[] = 'Employee Name Cant Be <strong>Empty</strong>';
                }

                if (empty($email)) {

                    $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
                }

                if (empty($phone)) {

                    $formErrors[] = 'Phone Cant Be <strong>Empty</strong>';
                }

                if (!is_numeric($phone)) {

                    $formErrors[] = 'Phone Cant Be <strong>Text</strong>';
                }


                if (strlen($employeeName) < 4) {

                    $formErrors[] = 'Employee Name Cant Be Less Than <strong>4</strong> Characters';
                }

                if (strlen($employeeName) > 20) {

                    $formErrors[] = 'Employee Name Cant Be More Than <strong>20</strong> Characters';
                }


                foreach($formErrors as $errors) {

                    echo '<div class="alert alert-danger">' . $errors . '</div>' ;
                }

                // Check If There's No Errors Proceed The Update Opertation

                if (empty($formErrors)) {

                    // Insert Employee In DataBase

                    $stmt = $con->prepare("INSERT INTO
                                            employee(name, username, password, phone, E_mail)
                                            VALUES(:zname, :zusername, :zpassword, :zphone, :zmail)");
                    $stmt->execute(array(

                        'zname'      => $employeeName,
                        'zphone'     => $phone,
                        'zmail'      => $email,
                        'zusername'  => $username,
                        'zpassword'  => $hashpass
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

        } else if ($do == 'Edit') {// Edit Page

            // Check If GEt Request userid Numeric & Get The Intehar Value Of It

            $userid = isset($_GET['empid']) && is_numeric($_GET['empid']) ? intval($_GET['empid']) : 0;

            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT * FROM employee WHERE E_ID = ? LIMIT 1");


            // Execute Query

            $stmt->execute(array($userid));

            // Fetch The Data

            $row = $stmt->fetch();

            // The Row Count

            $count = $stmt->rowCount();

            // If There is Such ID Show The Form

            if($count > 0) { ?>

                <!-- Start Html -->

                <div class="container">
                  <h1 class="text-center">Edit Employee</h1>
                    <form class="form-horizontal" action="?do=update" method="POST">
                        <input type="hidden" name="EID" value="<?php echo $row['E_ID']?>" />
                        <!-- Start UserName Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Employee Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="employee_name" value="<?php echo $row['name'] ?>" class="form-control" autocomplete="off" required="required" />
                            </div>
                        </div>
                        <!-- End UserName Filed -->

                        <!-- Start Email Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email" value="<?php echo $row['E_mail'] ?>" class="form-control" required="required" />
                            </div>
                        </div>
                        <!-- End Email Filed -->

                        <!-- Start Full-Name Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="phone" value="<?php echo $row['phone'] ?>" class="form-control" required="required" />
                            </div>
                        </div>
                        <!-- End Full-Name Filed -->

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



                $theMsg = '<div class="alert alert-danger">' . $stmt->rowCount(). ' There Is No Such ID</div>';

                redirectFunction($theMsg);
            }
/////////////////////////////////////==[update]==///////////////////////////////////////

        } else if ($do == 'update'){
            echo '<div class="container">';

            echo '<h1 class="text-center">Update Employee</h1>';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $name = $_POST['employee_name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $employeeid = $_POST['EID'];



                // Validate The Form

                $formErrors = array();

                if (empty($name)) {

                    $formErrors[] = 'Employee Name Cant Be <strong>Empty</strong>';
                }

                if (empty($email)) {

                    $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
                }

                if (strlen($name) < 4) {

                    $formErrors[] = 'Employee Name Cant Be Less Than <strong>4</strong> Characters';
                }

                if (strlen($name) > 20) {

                    $formErrors[] = 'Employee Name Cant Be More Than <strong>20</strong> Characters';
                }

                if (empty($phone)) {

                    $formErrors[] = 'Phone Cant Be <strong>Empty</strong>';
                }

                if (!is_numeric($phone)) {

                    $formErrors[] = 'Phone Cant Be <strong>Text</strong>';
                }

                foreach($formErrors as $errors) {

                    echo '<div class="alert alert-danger">' . $errors . '</div>' ;
                }

                // Check If There's No Errors Proceed The Update Opertation

                if (empty($formErrors)) {


                        // Update Data Base
                        $stmt = $con->prepare("UPDATE employee SET name = ?, phone = ?, E_mail = ? WHERE E_ID = ?");

                        $stmt->execute(array($name, $phone, $email, $employeeid));

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

          echo '<div class="container">';
            echo '<h1 class="text-center">Delete Member</h1>';


            // Check If GEt Request userid Numeric & Get The Intehar Value Of It

            $employeeid = isset($_GET['empid']) && is_numeric($_GET['empid']) ? intval($_GET['empid']) : 0;

            // Select All Data Depend On This ID

             $check = checkItem('E_ID', 'employee', $employeeid);

            // If There is Such ID Show The Form

            if($check > 0) {

                $stmt = $con->prepare("DELETE from employee  WHERE E_ID = :zuser");

                $stmt->bindParam(':zuser', $employeeid);

                $stmt->execute();

                $theMsg = '<div class="alert alert-success"> ID '.$employeeid.' Deleted</div>';

                redirectFunction($theMsg, 'back');

            } else {

                $theMsg = '<div class="alert alert-danger"> This Is ID is Not Exist</div>';

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
