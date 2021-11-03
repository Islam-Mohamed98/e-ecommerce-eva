<?php

    session_start();

    $noNavbar = ''; // To Not Include NavBar Page

    $pageTitle = 'Admin Login'; // Page Title

    // Check If UserName Already Logged In
    if (isset($_SESSION['Username'])) {
       header('location:dashboard.php'); //Redirect To DashBoard
    }

    // include Require files
    include 'init.php';


    // Check If User Coming From HTTP Post Request
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);

        // Check If User Exist in DataPass
        $stmt = $con->prepare("SELECT
                                    client_ID, username, password
                                FROM
                                    user
                                WHERE
                                    username = ?
                                AND
                                    password = ?
                                AND
                                    Group_ID = 1
                                LIMIT 1");

        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();


        // If Count > 0 This Mean The DataBase Contain Record Match With usernamme / password
        if ($count > 0) {
            $_SESSION['Username'] = $username; // Register $Session For username
            $_SESSION['ID'] = $row['client_ID']; // Register $Session For ID
            header('location:dashboard.php');
            exit();

        // If User Not Exist
        } else {
            $logfail = 'Wrong Username Or Password'; // Error Message
        }
    }
?>

  <!-- Start Infodiv -->
  <div class="infodiv">
    <div class="overlay-b"></div>
    <div class="container">
          <h5 class="text-center"> <?php getTitle (); ?> </h5>
    </div>
  </div>
  <!-- End Infodiv -->

  <!-- Start Login -->
  <div class="login-admin">
    <div class="container">
      <div class="loginformdiv">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

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

        <div class="form-group">
          <input type="text" name="user" autocomplete="off" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username">
        </div>
        <div class="form-group">
          <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="new-password">
        </div>
        <button type="submit" class="btn">Login</button>
      </form>
      </div>
    </div>
  </div>
  <!-- End Login -->


<?php include $tpl . "footer.php"; ?>
