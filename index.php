<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Upload Art</title>
</head>
<body>
    <?php 
    include 'nav.php';
    // Include the database configuration file  
    require_once 'config.php'; 
    
    // Get image data from database 
    $result = $conn->query("SELECT * FROM art"); 
    ?>

    
    <?php if($result->num_rows > 0){ ?>  
        <div class="container-fluid">
        <div class="row">
            <?php while($row = $result->fetch_assoc()){ ?>    
                    <div class="col-sm"> 
                    <div class="card1">
                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" />
                        <div class="content">
                            <h1><?php echo $row['art_name']; ?></h1>
                        </div>
                    </div> 
                    </div>
            <?php } ?>
        </div>    
        </div> 
    <?php }else{ ?> 
        <p class="status error">Image(s) not found...</p> 
    <?php } ?>
</body>
</html>