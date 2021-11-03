<?php
    ob_start();
    session_start();
    $pageTitle = 'Login';
    $navTitle= "My Account";
    include 'init.php';


    if(isset($_SESSION['musername'])) {
        header('location:index.php');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['log-in'])) {

            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashedpassword= sha1($password);

            $stmt = $con->prepare('SELECT
                                        client_ID, username, password
                                    FROM
                                        user
                                    WHERE
                                        username = ?
                                    AND
                                        password = ?');

            $stmt->execute(array($username, $hashedpassword));

            $get = $stmt->fetch();

            $count = $stmt->rowCount();

            if ($count > 0) {

                $_SESSION['musername'] = $username; // Register Session Name

                $_SESSION['mid'] = $get['client_ID'];  // Register Session ID

                header('location:index.php');
                exit();

            } else {

                $logfail = 'Wrong Username Or Password';
            }
        } else {

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

            // Get Data From Form

            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2'];
            $email      = $_POST['email'];
            $fullname   = $_POST['name'];

            // Errors Array

            $formErrors = array();


            // Check  Username

            if (isset($username)) {

                $filterUser = filter_var($username, FILTER_SANITIZE_STRING);

                if (strlen($filterUser) < 4) {

                    $formErrors[] = 'Your Username Must Be More Than 4 Characters';
                }
            }

            if (isset($fullname)) {

                $filterUser = filter_var($fullname, FILTER_SANITIZE_STRING);

                if (strlen($filterUser) < 4) {

                    $formErrors[] = 'Your Username Must Be More Than 4 Characters';
                }
            }

            // Check Password

            if (isset($password) && isset($password2)) {

                if(empty($password)) {

                    $formErros [] = 'Password Cant Be Empty';
                }

                if (sha1($password) !== sha1($password2)) {

                    $formErrors[] = 'Password Not Match';
                }
            }

            // Check Email

            if (isset($email)) {

                $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

                if (filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) {

                    $formErrors[] = 'This Email Is Not Valid';
                }

            }

            // if image extent not in array
            if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
                $formErrors[] = 'This Extension Is Not Allowed';
            }

            if ($avatarSize > 4194304) {
                $formErrors[] = 'Avatar Cant Be Larger than 4mb';
            }

            // Check If There's No Errors Proceed The User Add

            if (empty($formErrors)) {

              // Check If User Exist In DataBase

              $check = checkItem('username', 'user', $username);

              if ($check === 0) {

                  $avatar = rand(0, 100000) . '-' . $avatarName;

                  move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);

                // Check If User Exist In DataBase

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
                      'zpassword' => sha1($password),
                      'zavatar'   => $avatar

                  ));

                    // Echo Sucess Message If Username Is Not Exist

                    $theMsg = '<div class="alert alert-success">' . $username. ' Added</div>';

                    redirectFunction($theMsg, 'back');

                }else {

                    // Error  Message  When Username Exist

                    $theMsg = '<div class="alert alert-danger">This Username Already Exist</div>';

                    redirectFunction($theMsg, 'back');
                }
            }

        }

    }
?>
    <!-- ///////////////////////////////////////////////////////////////////////////-->




  <!-- Start Login -->
  <div class="login">
    <div class="container">
      <div class="loginformdiv">
        <a data-class="log-in" class="active"> Login </a>
        <a data-class="register"> Register </a>
        <?php
        // If there is Error Send it
        if (isset($logfail)) { ?>
            <div class = "alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
                <?php echo $logfail ?>
            </div>
        <?php } ?>

        <!-- Start Login Form -->
        <form class="log-in" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-group">
          <input type="text" name="username" class="form-control" placeholder="Username" required="required"/>
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control"  placeholder="Password" autocomplete="new-password" />
        </div>
        <button type="submit" name="log-in" class="btn">Login</button>
      </form>

      <!-- End Login Form -->

      <!-- Start Register Form -->
      <form  style="display:none;" class="register" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <input type="text" pattern=".{4,}"  title="Username Must Be Betwwen 4 & 8 Chars" autocomplete="off" name="username" class="form-control" placeholder="Username" required="required"/>
        </div>
        <div class="form-group">
          <input type="password" minlength="4" name="password" class="form-control"  placeholder="Password" autocomplete="new-password" />
        </div>
        <div class="form-group">
          <input type="password" minlength="4" name="password2" class="form-control"  placeholder="Password" autocomplete="new-password" />
        </div>
        <div class="form-group">
          <input type="text" pattern=".{4,}"  title="FullName Must Be Betwwen 4 & 8 Chars" autocomplete="off" name="name" class="form-control" placeholder="FullName" required="required"/>
        </div>
        <div class="form-group">
          <input type="email" name="email" class="form-control"  placeholder="Email"  autocomplete="off" />
        </div>
        <div class="form-group">
          <input type="file" name="avatar"  class="form-control" />
        </div>
      <button type="submit" name="register" class="btn">Register</button>
    </form>

    <?php

    if(!empty($formErrors)) {

        foreach($formErrors as $error ) {
            echo '<div class="erros">';
            echo '<p>' . $error . '</p>';
            echo '</div>';
        }
    }
    ?>
    <!-- End Register Form -->


      </div>
    </div>
  </div>
  <!-- End Login -->



<?php include $tpl .'footer.php';
ob_end_flush();
?>
