<?php

    include 'connect.php'; // To Connect To SQL

    // Routes

    $tpl    = 'includes/templates/'; // Template Directory
    $func   = 'includes/functions/'; // Functions Directory
    $css    = 'layout/css/'; // Css Directory
    $js     = 'layout/js/'; // Js Directory


    // Include The Important Files
    include $func . 'functions.php';
    include $tpl . 'header.php';

    if(!isset($noNavbar)) {include $tpl . 'navbar.php';}
