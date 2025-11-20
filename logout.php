<?php
session_start();

unset($_SESSION['user']); // Aquí eliminas SOLO esta variable

header("Location: login.php");
exit;
?>