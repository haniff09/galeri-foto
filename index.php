<?php
session_start();
if(isset($_SESSION['UserID'])){
    header("Location: home.php");
} else {
    header("Location: login.php");
}
?>
