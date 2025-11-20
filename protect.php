<?php
// You'd put this code at the top of any "protected" page you create

// Always start this first
session_start();

if ( !isset( $_SESSION['user'] ) ) {
    // Redirect them to the login page
    header("Location: /login.php");
}
?>