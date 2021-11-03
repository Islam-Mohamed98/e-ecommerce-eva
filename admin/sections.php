<?php

    /*
    ==================================
    ==
        Sections Page
    ==
    ==================================
    */

    ob_start(); // Out Put Buffering Start

    session_start();

    $pageTitle = 'Sections';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; ?>

        <div class="dashboard-main" data-class="sections" style="margin-left:15%;padding:50px 16px;">
        <?php

/////////////////////////////////////==[Manage]==///////////////////////////////////////


        if ($do == 'Manage') {

        // Get Data From Section table
        $sort = 'ASC';

        $sort_array = array('ASC ', 'DESC');

            if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

                $sort = $_GET['sort'];
            }

        $event = "SELECT * FROM section ORDER BY section_ID $sort ";

        $sections = sqlGlobal ($event, $fetch='fetchAll');

        ?>
        <h1 class="text-center">Manage Sections</h1>
        <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel panel-heading">
                        <i class="fa fa-edit"></i> Manage Sections
                        <div class="option pull-right">
                            <i class="fa fa-sort"></i> Ordereing:[
                            <a class="<?php //if($sort == 'Asc'){echo 'active';}?>"href="?sort=ASC">Asc </a>
                            |
                            <a class="<?php //if($sort == 'Desc'){echo 'active';}?>"href="?sort=DESC"> Desc</a> ]
                            <i class="fa fa-eye"></i> View :[
                            <span class ="active" data-view="full" >Full</span> |
                            <span data-view="classic">Classic</span> ]
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                            foreach($sections as $section){
                                echo '<div class="cat">';
                                    echo '<div class="hidden-buttons">';
                                        echo '<a href="sections.php?do=Edit&sectionid=' .$section['section_ID'] .'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>Edit</a>';
                                        echo '<a href="sections.php?do=Delete&sectionid=' .$section['section_ID'] .'" class="btn btn-xs btn-danger check"><i class="fa fa-times"></i>Delete</a>';
                                    echo '</div>';
                                    echo '<h3>' . $section['Name'] . '</h3>';
                                echo '</div>';
                                echo '<hr>';

                            }
                        ?>
                    </div>
                </div>
            <a class="add-category btn btn-primary" href="sections.php?do=Add"><i class="fa fa-plus"></i> Add New Section</a>
        </div>


        <?php


 /////////////////////////////////////==[Add]==///////////////////////////////////////


        }else if ($do =='Add'){ ?>

            <!-- Start Html -->

                <h1 class="text-center">Add New Section</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">

                        <!-- Start Name Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Section Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="name"  class="form-control" autocomplete="off" required="required" />
                            </div>
                        </div>
                        <!-- End Name Filed -->




                        <!-- Start Submit Filed -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 col-md-4">
                                <input type="submit" value="Add Section" class="btn btn-primary" />
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

                echo '<h1 class="text-center">Inseret Section</h1>';
                    echo '<div class="container">';

                // Get Variables From The Form

                $name       = $_POST['name'];
                //$desc       = $_POST['description'];
                //$order      = $_POST['ordering'];
                //$visible    = $_POST['visibility'];
                //$comment    = $_POST['commenting'];
                //$ads        = $_POST['ads'];
                //$parent     = $_POST['parent'];





                // Check If Section Exist In DataBase

                $check = checkItem('Name', 'section', $name);


                if ($check === 0) {

                    // Insert Section In DataBase

                    $stmt = $con->prepare("INSERT INTO
                                            section(Name)
                                            VALUES(:zname)");
                    $stmt->execute(array(

                        'zname'     => $name

                    ));

                    // Echo Sucess Message If Username Is Not Exist

                    $theMsg = '<div class="alert alert-success">' . $stmt->rowCount(). ' Recored Inserted</div>';

                    redirectFunction($theMsg, 'back');

                }else {

                    // Error  Message  When Section Exist

                    $theMsg = '<div class="alert alert-danger">This Section Already Exist</div>';

                    redirectFunction($theMsg, 'back');
                }




            } else {

                $errorMsg = '<div class="alert alert-danger">You Cant Open This Page Direct</div>';
                redirectFunction($errorMsg);
            }

            echo '</div>';


/////////////////////////////////////==[Edit]==///////////////////////////////////////


        } else if ($do == 'Edit') {

            // Check If GEt Request SectionID Numeric & Get The Intehar Value Of It

            $sectionid = isset($_GET['sectionid']) && is_numeric($_GET['sectionid']) ? intval($_GET['sectionid']) : 0;

            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT
                                        *
                                    FROM
                                        section
                                    WHERE
                                        section_ID = ? ");


            // Execute Query

            $stmt->execute(array($sectionid));

            // Fetch The Data

            $sections = $stmt->fetch();

            // The Row Count

            $count = $stmt->rowCount();

            // If There is Such ID Show The Form

            if($count > 0) { ?>

               <!-- Start Html -->

                <h1 class="text-center">Edit Section</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="sectionid" value="<?php echo $sections['section_ID']?>" />
                        <!-- Start Name Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="name"  class="form-control"  required="required"  value="<?php echo $sections['Name']; ?>" />
                            </div>
                        </div>
                        <!-- End Name Filed -->


                        <!-- Start Submit Filed -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 col-md-4">
                                <input type="submit" value="Save Section" class="btn btn-primary" />
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


        } else if ($do == 'Update'){

            echo '<h1 class="text-center">Update Section</h1>';
            echo '<div class="container">';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $id         = $_POST['sectionid'];
                $name       = $_POST['name'];
                //$desc       = $_POST['description'];
                //$order      = $_POST['ordering'];
                //$visiable   = $_POST['visibility'];
                //$comment    = $_POST['commenting'];
                //$ads        = $_POST['ads'];



                $stmt = $con->prepare("UPDATE
                                        section
                                    SET
                                        Name = ?
                                    WHERE
                                        section_ID = ?");

                $stmt->execute(array($name, $id));

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
            echo '<h1 class="text-center">Delete Section</h1>';

            // Check If GEt Request userid Numeric & Get The Intehar Value Of It

            $sectionid = isset($_GET['sectionid']) && is_numeric($_GET['sectionid']) ? intval($_GET['sectionid']) : 0;

            // Select All Data Depend On This ID

             $check = checkItem('section_ID', 'section', $sectionid);

            // If There is Such ID Show The Form

            if($check > 0) {

                $stmt = $con->prepare("DELETE FROM section WHERE section_ID = :zsecid");

                $stmt->bindParam(':zsecid', $sectionid);

                $stmt->execute();

                $theMsg = '<div class="alert alert-success"> ID '.$sectionid.' Deleted</div>';

                redirectFunction($theMsg, 'back');

            } else {

                $theMsg = '<div class="alert alert-danger">' . $stmt->rowCount(). ' This Is ID is Not Exist</div>';

                redirectFunction($theMsg);
            }

            echo '</div>';


        }
/////////////////////////////////////////////////////////////////////////////////////////


        include $tpl . 'footer.php';

    } else {

        header('location: index.php');
        exit();
    }

ob_end_flush();

?>
