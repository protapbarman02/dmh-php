<?php 
session_start();
session_destroy();
unset($_SESSION['isLoggedIn']);
header("location:login.php");
?>