<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $password = "";
$name_err = $password_err = $insert_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } else{
        $name = $input_name;
    }
    
    // Validate password
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter a password.";     
    } else {
        $password = password_hash($input_password, PASSWORD_DEFAULT);
    }
    
    
    // Check input errors before inserting in databaseogin.php
    if(empty($name_err) && empty($password_err)){
        
        try{
            $sql = "INSERT INTO accounts (name, password) VALUES (:name, :password)";
            if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":password", $password);
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    header('Location: index.php');
                }

                
            }
        }catch(PDOException $e){
            if($e->getCode() ==  '23000'){
                $insert_err = 'User alreay exists';
            }else{
                $insert_err = 'Ups, there was an unknown error';
            }
        }
        


    // Close connection
    unset($pdo);
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Register</h2>
                    <p>Create a new account</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  >
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>

                        <a href="login.php" class="btn btn-info ml-2">Login</a>
                        <?php if(!empty($insert_err)): ?>
                            <div class="alert alert-danger mt-3"><?php echo $insert_err; ?></div>
                        <?php endif; ?>                    
                    </form>
                    
                </div>
            </div>        
        </div>
    </div>
</body>
</html>