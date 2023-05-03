<?php 
    session_start();
    $num = $_SESSION["number"];
    $_SESSION["number"] = 0;
    header("location:number.php");
?>