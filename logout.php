<?php
session_start();

unset($_SESSION['user']); // Aquí eliminas SOLO esta variable

    header("Location: http://localhost/php/MySQL/Mi%20crud/login.php");
    exit;
?>