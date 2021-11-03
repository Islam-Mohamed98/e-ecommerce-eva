<?php
    
    
    session_start(); // Start The Session

    session_unset(); // UnSet The Data

    session_destroy(); // Destroy the Session

    header ('location: index.php');
    exit();
