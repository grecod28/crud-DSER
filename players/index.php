<?php  
    require '../protect.php';

    $team_id = trim($_GET["team_id"]);
                    if(empty($team_id)){
                        die('Team id cannot be empty');
                    } elseif(!filter_var($team_id, FILTER_VALIDATE_INT)){
                        die('Invalid param for team id');
                    }

    $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $_SESSION['players_page'] = $current_url;
    $_SESSION['team_id'] = $team_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left"> Details</h2>
                        <a href="create.php?team_id=<?php echo htmlspecialchars($team_id)?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Player</a>
                    </div>
                    <?php
                    
                    
                    // Include config file
                    require_once "../config.php";
                    
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM player WHERE id_team = :id";
                    
                    
                    if($stmt = $pdo->prepare($sql)){
                        $stmt->bindParam(':id', $id_team);

                        $id_team = $team_id;

                        if($stmt->execute()){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Salary</th>";
                                        echo '<th><a href="../" title="Go back" data-toggle="tooltip" class="fa fa-arrow-left"></a></th>';
                                        echo "</td>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['salary'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='.$row['id'].'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='.$row['id'].'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='.$row['id'].'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                        }else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    }
                    
                    // Close connection
                    unset($pdo);
                    
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>