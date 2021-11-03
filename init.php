<?php

    // Error Reporting

    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    include 'admin/connect.php'; // To Connect To SQL

    $sessionUser = '';

    if (isset($_SESSION["musername"])) {
        $sessionUser = $_SESSION["musername"];
    }

    // Routes

    $tpl    = 'includes/templates/'; // Template Directory
    $func   = 'includes/functions/'; // Functions Directory
    $css    = 'layout/css/'; // Css Directory
    $js     = 'layout/js/'; // Js Directory
    $img    = 'layout/images/'; // Images Directory


    // Include The Important Files
    include $func . 'functions.php';
    include $tpl . 'header.php';
