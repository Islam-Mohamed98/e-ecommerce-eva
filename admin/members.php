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

        <div class="dashboard-main" data-class="clients" style="margin-left:15%;padding:50px 16px;">
        <?php
/////////////////////////////////////==[Manage]==///////////////////////////////////////

        if ($do == 'Manage') { // Manage Page

            $query = '';

            if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

                $query = 'AND RegStatus = 0';

            }

            // Get Data From SQL Except GroupID 1

            $stmt = $con->prepare("SELECT * FROM client INNER JOIN user ON client.client_ID =user.client_ID  WHERE Group_ID !=1 $query");

            // Execute The Data From SQL

            $stmt->execute();

            $rows = $stmt->fetchAll();



        ?>

                <div class="container">
                  <h1 class="text-center">Manage Member</h1>
                    <div class="table-responsive">
                    <table class="main-table text-center table table-bordered mange-members">
                    <tr>
                        <td>#ID</td>
                        <td>username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Register Date</td>
                        <td>Image</td>
                        <td>Control</td>
                    </tr>
                    <?php

                    foreach($rows as $row) {
                        echo'<tr>';
                            echo'<td>' . $row['client_ID'] . '</td>';
                            echo'<td>' . $row['username'] . '</td>';
                            echo'<td>' . $row['Email'] . '</td>';
                            echo'<td>' . $row['name'] . '</td>';
                            echo'<td>' . $row['Date'] . '</td>';?>

                            <td>
                              <img style="height: auto; width: 150px;"class="card-img-top" src="..\uploads\avatars\<?php
                              if(isset($row['avatar'])){
                                echo $row['avatar'];
                              } else {
                                echo 'default-non.png';
                              }
                              ?>" />
                            </td>
<?php

                            echo'<td>
                                    <a href="members.php?do=Edit&userid=' .$row['client_ID']. '"class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                    <a href="members.php?do=Delete&userid='.$row['client_ID'].'" class="btn btn-danger check"><i class="fas fa-times"></i>Delete</a>';
                            echo '</td>';
                        echo'<tr>';
                    }
                    ?>
                    </table>
                    </div>
                    <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Member</a>
                </div>


        <?php
 /////////////////////////////////////==[Add]==///////////////////////////////////////

        }else if ($do =='Add'){ // Add Members Page

                ?>
            <!-- Start Html -->

                <div class="container">
                  <h1 class="text-center">Add New Member</h1>
                    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">

                        <!-- Start UserName Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">UserName</label>
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
                                <input type="email" name="email"  class="form-control" required="required" placeholder="Email Must Be Valid" />
                            </div>
                        </div>
                        <!-- End Email Filed -->

                        <!-- Start Full-Name Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="full"  class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page" />
                            </div>
                        </div>
                        <!-- End Full-Name Filed -->



                        <!-- Start Avatar Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">User Avatar</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="file" name="avatar"  class="form-control" />
                            </div>
                        </div>
                        <!-- End Avatar Filed -->

                        <!-- Start Submit Filed -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 col-md-4">
                                <input type="submit" value="Add Member" class="btn btn-primary" />
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

                // Upload variables

                $avatar = $_FILES['avatar']; // Array For Uploaded image

                $avatarName = $_FILES['avatar']['name']; // Name of img
                $avatarSize = $_FILES['avatar']['size']; // Size of Img
                $avatarTmp = $_FILES['avatar']['tmp_name']; // Path of img
                $avatarType = $_FILES['avatar']['type']; // type of img

                // List Of allowed File Types To Upload
                $avatarAllowedExtension = array("jepg", "jpg", "png", "gif");

                // Get Avatar Extension
                $explodef = explode('.', $avatarName);

                $avatarExtension = strtolower(end ($explodef)); // get last string in lowercase



                $username = $_POST['username'];
                $pass = $_POST['password'];
                $email = $_POST['email'];
                $fullname = $_POST['full'];
                $hashpass = sha1($_POST['password']);

                // Validate The Form

                $formErrors = array();

                if (empty($username)) {

                    $formErrors[] = 'Username Cant Be <strong>Empty</strong>';
                }

                if (empty($email)) {

                    $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
                }

                if (empty($fullname)) {

                    $formErrors[] = 'FullName Cant Be <strong>Empty</strong>';
                }

                if (empty($pass)) {

                    $formErrors[] = 'Password Cant Be <strong>Empty</strong>';
                }

                if (strlen($username) < 4) {

                    $formErrors[] = 'Username Cant Be Less Than <strong>4</strong> Characters';
                }

                if (strlen($username) > 20) {

                    $formErrors[] = 'Username Cant Be More Than <strong>20</strong> Characters';
                }

                // if image extent not in array
                if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
                    $formErrors[] = 'This Extension Is Not Allowed';
                }


                if (empty($avatarName)) {
                    $formErrors[] = 'Avatar Allowed';
                }

                if ($avatarSize > 4194304) {
                    $formErrors[] = 'Avatar Cant Be Larger than 4mb';
                }

                foreach($formErrors as $errors) {

                    echo '<div class="alert alert-danger">' . $errors . '</div>' ;
                }

                // Check If There's No Errors Proceed The Update Opertation

                if (empty($formErrors)) {

                    $avatar = rand(0, 100000) . '-' . $avatarName;

                    move_uploaded_file($avatarTmp, "..\uploads\avatars\\" . $avatar);

                    // Check If User Exist In DataBase

                    $check = checkItem('username', 'user', $username);

                    if ($check === 0) {

                        // Insert UserInfo In DataBase

                        $stmt = $con->prepare("INSERT INTO
                                                client(name, Email)
                                                VALUES(:zfullname, :zmail)");
                        $stmt->execute(array(
                            'zmail'     => $email,
                            'zfullname' => $fullname
                        ));


                        $stmt = $con->prepare("INSERT INTO
                                                user(client_ID, username, password, Date, avatar)
                                                VALUES(LAST_INSERT_ID(), :zuser, :zpassword, now(), :zavatar)");
                        $stmt->execute(array(

                            'zuser'     => $username,
                            'zpassword' => $hashpass,
                            'zavatar'   => $avatar

                        ));

                        // Echo Sucess Message If Username Is Not Exist

                        $theMsg = '<div class="alert alert-success">' . $stmt->rowCount(). ' Recored Inserted</div>';

                        redirectFunction($theMsg, 'back');

                    }else {

                        // Error  Message  When Username Exist

                        $theMsg = '<div class="alert alert-danger">This Username Already Exist</div>';

                        redirectFunction($theMsg, 'back');
                    }
                }

            } else {

                $errorMsg = '<div class="alert alert-danger">You Cant Open This Page Direct</div>';
                redirectFunction($errorMsg);
            }

            echo '</div>';

/////////////////////////////////////==[Edit]==///////////////////////////////////////

        } else if ($do == 'Edit') {// Edit Page

            // Check If GEt Request userid Numeric & Get The Intehar Value Of It

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT * FROM client INNER JOIN user On client.client_ID = user.client_ID WHERE client.client_ID = ? LIMIT 1");


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
                  <h1 class="text-center">Edit Member</h1>
                    <form class="form-horizontal" action="?do=update" method="POST">
                        <input type="hidden" name="userid" value="<?php echo $row['client_ID']?>" />
                        <!-- Start UserName Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">UserName</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="username" value="<?php echo $row['username'] ?>" class="form-control" autocomplete="off" required="required" />
                            </div>
                        </div>
                        <!-- End UserName Filed -->

                        <!-- Start Password Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Plank If u Dont Want To Change Pw" />
                                <input type="hidden" name="oldpassword" value='<?php echo $row['password'] ?>'/>
                            </div>
                        </div>
                        <!-- End Password Filed -->

                        <!-- Start Email Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required" />
                            </div>
                        </div>
                        <!-- End Email Filed -->

                        <!-- Start Full-Name Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="full" value="<?php echo $row['name'] ?>" class="form-control" required="required" />
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

            echo '<h1 class="text-center">Update Member</h1>';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $id = $_POST['username'];
                $email = $_POST['email'];
                $fullname = $_POST['full'];
                $userid = $_POST['userid'];

                // Password Trick

                $pw = empty($_POST['newpassword']) ? $_POST['oldpassword'] : $pw = sha1($_POST['newpassword']);

                // Validate The Form

                $formErrors = array();

                if (empty($id)) {

                    $formErrors[] = 'Username Cant Be <strong>Empty</strong>';
                }

                if (empty($email)) {

                    $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
                }

                if (empty($fullname)) {

                    $formErrors[] = 'FullName Cant Be <strong>Empty</strong>';
                }

                if (strlen($id) < 4) {

                    $formErrors[] = 'Username Cant Be Less Than <strong>4</strong> Characters';
                }

                if (strlen($id) > 20) {

                    $formErrors[] = 'Username Cant Be More Than <strong>20</strong> Characters';
                }

                foreach($formErrors as $errors) {

                    echo '<div class="alert alert-danger">' . $errors . '</div>' ;
                }

                // Check If There's No Errors Proceed The Update Opertation

                if (empty($formErrors)) {

                    $stmt2 = $con->prepare("SELECT * FROM client INNER JOIN user ON client.client_ID =user.client_ID WHERE user.username = ? AND
                       user.client_ID != ?");
                    $stmt2->execute(array($id, $userid));

                    $count = $stmt2->rowCount();


                    if ($count === 0) {

                        // Update Data Base
                        $stmt = $con->prepare("UPDATE client , user SET user.username = ?, client.Email = ?, client.name = ?, user.password = ? WHERE client.client_ID = user.client_ID AND client.client_ID = ?");

                        $stmt->execute(array($id, $email, $fullname, $pw,  $userid));

                        // Echo Sucess Message

                        $theMsg = '<div class="alert alert-success">' . $stmt->rowCount(). ' Recored Updated</div>';

                        redirectFunction($theMsg, 'back');

                    } else {

                        $theMsg = '<div class="alert alert-danger">This Username Already Exist</div>';

                        redirectFunction($theMsg, 'back');
                    }

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
