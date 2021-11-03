<?php

    $den = 'mysql:host=localhost;dbname=onlineshop2';
    $user = 'root';
    $pass = '';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try {
        $con = new PDO($den, $user, $pass, $option);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo 'You Are Connect Welcome To DataBase';
    }
    catch (PDOException $e) {
        echo 'Faild To Connect' . $e->getMessage();
    }
