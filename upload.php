<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="icon" href="images/art-word.png" type="image/x-icon">
    <title>Upload Art</title>
    <style>
        body{
            background-image: url('images/upload-background1.jpg');     
            background-size: cover;
        }
        
        .card{
            background-image: url('images/form-bg.jpg');
            background-size: cover;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; 
    ?>
    <div class="card m-auto w-50 shadow-lg p-3 mt-5 bg-white rounded" style="top:60px">
    <?php 
        // Include the database configuration file  
        include 'config.php'; 
        
        // If file upload form is submitted 
        $status = $statusMsg = ''; 
        if(isset($_POST["submit"])){ 
            $status = 'error'; 
            if(!empty($_FILES["image"]["name"])) { 
                // Get file info 
                $fileName = basename($_FILES["image"]["name"]); 
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType, $allowTypes)){ 
                    $image = $_FILES['image']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($image)); 
                    $art = $_POST['art'];
                    $artistname = $_POST['artistname'];
                    $category = $_POST['category'];
                    $social = $_POST['social'];
                    $sql = "INSERT INTO art (`art_name`,`artist_name`,`category`,`image`,`insta`) VALUES ('$art','$artistname','$category','$imgContent','$social')";
                    $insert=mysqli_query($conn,$sql);
                
                    // Insert image content into database 
                    // $insert = $db->query("INSERT into art (image, uploaded) VALUES ('$imgContent', NOW())"); 
                    
                    if($insert){ 
                        $status = 'success'; 
                        $statusMsg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        File Uploaded Successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>'; 
                      header( "refresh:2;url=index.php" );
                    }else{ 
                        $statusMsg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Some Error Occurred
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>'; 
                    }  
                }else{ 
                    $statusMsg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } 
            }else{ 
                $statusMsg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                Please select an image file to upload.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            } 
        } 
        
        // Display status message 
        echo $statusMsg; 
    ?>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Art Name</label>
                    <input type="text" class="form-control" id="ArtName" name="art">
                </div>
                <div class="form-group">
                    <label>Artist Name</label>
                    <input type="text" class="form-control" name="artistname" id="ArtistName">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Category</label>
                    <input type="text" class="form-control" name="category" id="Category">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Social link</label>
                    <input type="text" class="form-control" name="social" id="Social">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Upload your art</label>
                    <input type="file" class="form-control-file" name="image" id="Image">
                </div>
                <div class="col-md-12 text-center">
                    <!-- <button type="submit" class="btn btn-primary" name="sumbit">Submit</button> -->
                    <input type="submit" class="btn btn-primary" name="submit" value="Upload">
                </div>
            </form>
        </div>
    </div>
</body>
</html>