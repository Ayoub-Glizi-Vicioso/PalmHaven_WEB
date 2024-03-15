<?php
session_start();

if(isset($_SESSION['email'])){
    $_SESSION = array();

    session_destroy();
    header("location: connexion.php");
    exit;
}
else{
    header("location: connexion.php");
    exit;
}
?>