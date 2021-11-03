<?php





/*
                            =========================
                            == Sql Global Function ==
                            =========================
*/

    function sqlGlobal ($event, $fetch='fetch', $parameters = null, $type = null) {

        global $con;

        $getrequired = $con->prepare($event);

        if ($parameters == null){

            $getrequired->execute();

        } else {

            $getrequired->execute(array($parameters));
        }

        $required = $getrequired->$fetch();
        $count = $getrequired->rowCount();

        if ($type != 'count'){

        return $required;

        } else {

        return $count;

        }
    }






    /*
    ** geTitle V1.0
    ** Title Function That Echo The Page Title In Case The Page
    ** Has The Page Variable $pageTitle And Echo Defult Title For Other Pages
    */

    function getTitle () {

        global $pageTitle;

        if (isset($pageTitle)) {

            echo $pageTitle;

        } else {

            echo 'Default';
        }
    }

    /*
    **  redirectFunction V2.0
    **  Redirect To Wanted Page
    **  Parameters[$errorMsg, $seconds,$pageName ]
    ** $theMsg =  Echo The Message [ Error | Sucess | Warning ]
    ** url = The Link You Want To Redirect To
    ** $seconds= The Seconds Before Direct To Page
    ** $pageName = Paged Which Direct To
    */

    function redirectFunction ($theMsg, $url = null, $seconds = 3) {

            if ($url === null) {

                $url = 'index.php';
                $link = 'HomePage';

            } else {

                if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

                    $url = $_SERVER['HTTP_REFERER'];

                    $link = 'Previous Page';

                }else {

                    $url = 'index.php';
                    $link = 'HomePage';
                }


            }

            echo $theMsg;

            echo "<div class='alert alert-info'>You Will Directed To $link Page After $seconds</div>";


        header("refresh:$seconds;url=$url");
        exit();
    }


/*
** CheckFunction V1.0
** Function To Check Item In Database [Function Accept Parameters]
** $select = The Item To Select [Example: user, item, categories]
** $from = The Table To Select From [Example: users, items, categories]
** $value = The Value Of Select [Example: osama, box, electronics]
*/

function checkItem ($select, $from, $value){

    global $con;

    $statement = $con->prepare("SELECT $select From $from WHERE $select = ?");

    $statement->execute(array($value));

    $count = $statement->rowCount();

    return $count ;
}

/*
** Count Number Of Items Function V1.0
** Function To Count Number Of Items Rows
** $item = The Item To Count
** $table = The Table To Choose From
*/

function countItems ($item, $table) {

    global $con;

    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

    $stmt2->execute();

    return $stmt2->fetchColumn();
}

/*
** Get Latest Record Function v1.0
** Function To Get The Lastest Items From DataBase [ Users | Items | Comments]
** $select = Filed To Select
** $table = The Table Choose From
** $order = The Desc Order
** $limit = Number Of Records To Get
*/

function getLatest ($select, $table, $order, $limit = 5) {

    global $con;

    $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $getstmt->execute();

    $rows = $getstmt->fetchAll();

    return $rows;
}
