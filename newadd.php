<?php
    ob_start();

    session_start();

    $pageTitle = 'Create New Item';

    $navTitle = "Add Product";

    include 'init.php';

    if (isset($_SESSION['musername'])) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Upload variables

            $productImg = $_FILES['product-img']; // Array For Uploaded image

            $productImgName = $_FILES['product-img']['name']; // Name of img
            $productImgSize = $_FILES['product-img']['size']; // Size of Img
            $productImgTmp = $_FILES['product-img']['tmp_name']; // Path of img
            $productImgType = $_FILES['product-img']['type']; // type of img

            // List Of allowed File Types To Upload
            $productImgAllowedExtension = array("jepg", "jpg", "png", "gif");

            // Get Avatar Extension
            $explodef = explode('.', $productImgName);

            $productImgExtension = strtolower(end ($explodef)); // get last string in lowercase

            $title            = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $quantity         = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);
            $price            = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $category         = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
            $description      = filter_var($_POST['description'], FILTER_SANITIZE_STRING);


        // Validate The Form

            $formErrors = array();

            if (empty($title)) {

                $formErrors[] = 'Item Name Cant Be <strong>Empty</strong>';
            }

            if (empty($description)) {

                $formErrors[] = 'Description Cant Be <strong>Empty</strong>';
            }

            if (empty($quantity)) {

                $formErrors[] = 'Price Cant Be <strong>Empty</strong>';
            }

            if (empty($price)) {

                $formErrors[] = 'Price Cant Be <strong>Empty</strong>';
            }


            if (strlen($category == 0)) {

                $formErrors[] = 'You Must Choose <strong>Category</strong> Characters';
            }

            // if image extent not in array
            if (! empty($productImgName) && ! in_array($productImgExtension, $productImgAllowedExtension)) {
                $formErrors[] = 'This Extension Is Not Allowed';
            }


            if (empty($productImgName)) {
                $formErrors[] = 'Product Image Allowed';
            }

            if ($productImgSize > 4194304) {
                $formErrors[] = 'Product Image Cant Be Larger than 4mb';
            }



            // Check If There's No Errors Proceed The Update Opertation

            if (!empty($formErrors)) {

                 foreach($formErrors as $errors) {

                    echo '<div class="alert alert-danger">' . $errors . '</div>' ;
                 }
            } else {

              $productImg = rand(0, 100000) . '-' . $productImgName;

              move_uploaded_file($productImgTmp, "uploads\product_images\\" . $productImg);

              // Check Product Name
              $stmt = $con->prepare("SELECT * FROM products WHERE products.name = ?");
              $stmt->execute(array($title));
              $product = $stmt->fetch();
              $count = $stmt->rowCount();

              // If This Name Not Exist
              if ($count == 0 ) {
                // Insert UserInfo In DataBase

                $stmt = $con->prepare("INSERT INTO
                                        products(name, cat_ID)
                                        VALUES(:zname, :zcatID)");
                $stmt->execute(array(

                    'zname'             => $title,
                    'zcatID'            => $category

                ));

                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount(). ' Recored Inserted</div>';

                $stmt = $con->prepare("INSERT INTO
                                        client_products(client_ID, P_ID, Price, Quantity, date, description, Approve, product_image)
                                        VALUES(:zmemberID, LAST_INSERT_ID(), :zprice, :zquantity, now(), :zdescription, 1, :zproductimage)");
                $stmt->execute(array(

                    'zmemberID'         => $_SESSION['mid'],
                    'zprice'            => $price,
                    'zquantity'         => $quantity,
                    'zdescription'      => $description,
                    'zproductimage'     => $productImg

                ));


                  // Echo Sucess Message If Username Is Not Exist


                  if ($stmt) {

                    $theMsg = '<div class="alert alert-success">Product Added</div>';
                    redirectFunction($theMsg, 'back', 3);
                  }

              } else { // ProductName Already Exist

                // Check If user Already Create Product With Same name

                $stmt = $con->prepare("SELECT * FROM client_products WHERE client_ID = ? AND P_ID = ?");
                $stmt->execute(array($_SESSION['mid'], $product['P_ID']));
                $check = $stmt->rowCount();

                if ($check == 0) { // IF user Dont have Product With Same Name

                  $stmt = $con->prepare("INSERT INTO
                                          client_products(client_ID, P_ID, Price, Quantity, date, description, Approve, product_image)
                                          VALUES(:zmemberID, :zpid, :zprice, :zquantity, now(), :zdescription, 1, :zproductimage)");
                  $stmt->execute(array(

                      'zmemberID'         => $_SESSION['mid'],
                      'zpid'              => $product['P_ID'],
                      'zprice'            => $price,
                      'zquantity'         => $quantity,
                      'zdescription'      => $description,
                      'zproductimage'     => $productImg

                  ));

                  if ($stmt) {

                    $theMsg = '<div class="alert alert-success">Product Added</div>';
                    redirectFunction($theMsg, 'back', 3);

                  }

              }else { // IF user Has Product With Same Name
                  $theMsg = '<div class="alert alert-danger">You Already Have Product With Same Name</div>';
                  redirectFunction($theMsg, 'back', 3);
                }

            }
            }

        }


?>


<h1 class="text-center"><?php echo $pageTitle ?></h1>

    <div style="margin: 50px 0 ;"class="information block">
        <div class="container">
            <div class="card card-primary">
                <div class="card-header"><?php echo $pageTitle ?></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">


                    <!-- Start Add Adv Form ---------------------------------------------->

                            <form class="form-horizontal " action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">

                            <!-- Start Categories Filed -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-10 col-md-9">
                                    <select class ="form-control" name="category">
                                        <option value ="0">...</option>
                                        <?php
                                            foreach(getAllFrom('catagory') as $cat) {
                                                echo'<option value ="' . $cat['ID'].'">' . $cat['Name']. '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- End Categories Filed -->

                            <!-- Start Name Filed -->

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Product Name</label>
                                <div class="col-sm-10 col-md-9">
                                    <input
                                           type="text"
                                           name="name"
                                           class="form-control live"
                                           required="required"
                                           maxlength="15"
                                           autocomplete="off"
                                           data-class = ".live-title"/>
                                </div>
                            </div>
                            <!-- End Name Filed -->

                            <!-- Start Description Filed -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10 col-md-9">
                                    <textarea type="text" name="description" class="form-control" rows="5" required="required" data-class = ".live-desc">  </textarea>
                                </div>
                            </div>
                            <!-- End Description Filed -->

                            <!-- Start Avatar Filed -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Product Image</label>
                                <div class="input-group mb-3 col-md-9">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-images"></i></span>
                                  </div>
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="product-img" >
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                  </div>
                                </div>
                            </div>
                            <!-- End Avatar Filed -->

                            <!-- Start Price Filed -->
                            <div class="form-group">
                              <label class="col-sm-2 control-label">Quantity</label>
                              <div class="col-sm-2 col-md-2">
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
                                <label class="col-sm-3 control-label">Price</label>
                                <div class="col-sm-2 col-md-2">
                                    <input
                                           type="text"
                                           name="price"
                                           class="form-control live"
                                           required="required"
                                           data-class = ".live-price"/>
                                </div>
                            </div>
                            <!-- End Price Filed -->


                            <!-- Start Submit Filed -->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-10 col-md-4">
                                    <input type="submit" value="Add Product" class="btn btn-sm btn-primary" />
                                </div>
                            </div>
                            <!-- End Submit Filed -->
                        </form>
                        </div>

            <!-- End Add Adver Form ---------------------------------------------->

            <!-- Start adver Review

                        <div class="col-md-4">
                        <div class="thumbnail item-box live-preview">
                        <span class="price-tag live-price"> 0</span>
                        <img class="img-fluid" src="<?php //echo $img ?>default-non.png" alt="" />
                        <div class="caption">
                            <h3 class="live-title"> Title </h3>
                           <p class="live-desc">Description </p>
                            </div>
                        </div>
                        </div>

             End adver Review ------------------------------------------------->

            <!-- Start Looping Through Erros ------------------------------------------------->


                    </div>



            <!-- End Looping Through Erros ------------------------------------------------->
                </div>
            </div>
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
