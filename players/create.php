<?php
require_once '../protect.php';
require_once "../config.php";

$name = $salary = $team  = "";
$name_err = $salary_err = $image_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validar nombre
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validar salario
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }

    $target_dir = "uploads/";
    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

    // Generar un UUID para el nombre del archivo
    $uuid = bin2hex(random_bytes(16)); // genera un identificador único
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . $uuid . "." . $imageFileType;

    $uploadOk = 1;

    // Comprobar tamaño
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Comprobar si es imagen
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $uploadOk = 0;
        }
    }

    // Subir archivo
    if ($uploadOk == 0) {
        $image_err = 'Error uploading image';
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file has been uploaded with UUID name.<br>";
        } else {
            $image_err = 'Error uploading image';
        }
    }
    
    // Insertar en la base de datos
    if(empty($name_err) && empty($salary_err) && empty($image_err)){
        $sql = "INSERT INTO player (name, salary, id_team, image_path) VALUES (:name, :salary, :team, :path)";
 
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":salary", $param_salary);
            $stmt->bindParam(":team", $param_team);
            $stmt->bindParam(":path", $param_path);
            
            $param_name = $name;
            $param_salary = $salary;
            $param_team = $_SESSION['team_id'];
            $param_path = $target_file; // aquí guardamos la ruta con UUID
            
            if($stmt->execute()){
                header('Location: ' . $_SESSION['players_page']);
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        unset($stmt);
    }
    unset($pdo);
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add a player to the team.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" accept="image/*" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" >
                            <span class="invalid-feedback"><?php echo $image_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="javascript:history.back()" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>