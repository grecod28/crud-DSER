<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'santiago');
define('DB_PASSWORD', 'abc123.');
define('DB_NAME', 'soccer');

// Mostrar errores para depuración (sólo en desarrollo)
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
 
/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ( isset( $_SESSION['user'] ) ){
    echo '<a href="/logout.php" class="btn btn-danger position-fixed" style="top: 20px; left: 20px;">
        <i class="fa fa-plus"></i> Go out
    </a>';
}   
 

} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>