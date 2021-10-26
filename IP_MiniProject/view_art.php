<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
    <link rel="icon" href="images/art-word.jpg" type="image/x-icon">
    <title>View Art</title>

    <style>
        body{
            background-image:  url('images/view-art-bg.jpg');     
            background-size: cover;
        }

        .user-art{
            display: block;
            margin-left: auto;
            margin-right: auto;
            width:50%;
            border-radius: 15px;
            height: 20%;
        }

        .sm-handle{
            text-align:center;
            font-size: larger;
            border-radius: 30px;
            margin-top: 35px;
            color: white;
            background-color: rgb(125 125 125)
        }

        .sm-handle a{
            text-decoration: none;
            background-color: rgb(125 125 125);
            padding: 5px 15px;
        }

        .sm-handle a:hover{
            color: rgb(30 30 30);
        }
        
        .fa {  
            font-size: 23px;  
            border-radius: 30px;
        }  

        .fa-instagram {
            color: #bc2a8d; 
        } 
    </style>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <div class="container-fluid">
        <h2 class="text-center pt-4"><b>Art Details</b></h2>
        <?php
            include 'config.php';
            $aid=$_GET['id'];
            $sql = "SELECT * FROM  art where id=$aid";
            $result=mysqli_query($conn,$sql);
            if(!$result)
            {
                echo "Error : ".$sql."<br>".mysqli_error($conn);
            }
            $row=mysqli_fetch_assoc($result);

        ?>
        <div class="card2">
            <img class="user-art" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>"/>
        </div>
        
        <div class="sm-handle">
            <p>
                Art Name: <?php echo $row['art_name']?>&nbsp;&nbsp;|&nbsp;&nbsp;
                Artist Name: <?php echo $row['artist_name']?>&nbsp;&nbsp;|&nbsp;&nbsp;
                Category: <?php echo $row['category']?>&nbsp;&nbsp;|&nbsp;&nbsp;
                Rating: <?php echo $row['rating'].'/5'?>&nbsp;&nbsp;|&nbsp;&nbsp;
                Follow on: <a class="fa fa-instagram" href="<?php echo $row['insta']?>">&nbsp;Instagram</a>
            </p>
        </div>
    </div>
  </body>
</html>