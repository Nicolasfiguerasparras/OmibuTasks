<?php
    session_start();
    session_destroy();
    unset($_COOKIE['sesion']);
    header("location:index.php");
?>