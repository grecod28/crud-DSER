<?php
require_once '../protect.php';

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "../config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM player WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $salary = $row["salary"];
                $imagePath = $row["image_path"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: ../error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: ../error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            display: flex;
            justify-content: center;   /* centra horizontalmente */
            align-items: center;       /* centra verticalmente */
            height: 100vh;             /* ocupa todo el alto de la ventana */
            width: 100%;               /* ocupa todo el ancho */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card" style="width: 18rem;">
        <img src="<?php echo htmlspecialchars($imagePath)?>" class="card-img-top" alt="Player Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo $name ?></h5>
            <p class="card-text"><?php echo $salary ?></p>
            <a href="javascript:history.back()" class="btn btn-primary">Back</a>       
        </div>
        </div>
    </div>
</body>
</html>