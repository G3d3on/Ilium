<?php

    require "db-functions.php";
    session_start();

    if(!empty($_POST['name'])){
        $ridingName = $_POST['name'];
        $_SESSION['riding'] = findRidingByName($ridingName);
        
        header("Location: riding.php");
    } else header("Location: index.php");

?>