<?php include 'config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    
    <link href='jquery-bar-rating-master/dist/themes/fontawesome-stars.css' rel='stylesheet' type='text/css'>
    
    <title>Upload Art</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="jquery-bar-rating-master/dist/jquery.barrating.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function() {
            $('.rating').barrating({
                theme: 'fontawesome-stars',
                onSelect: function(value, text, event) {

                    // Get element id by data-id attribute
                    var el = this;
                    var el_id = el.$elem.data('id');

                    // rating was selected by a user
                    if (typeof(event) !== 'undefined') {
                        
                        var split_id = el_id.split("_");

                        var postid = split_id[1];  // postid

                        // AJAX Request
                        $.ajax({
                            url: 'rating_ajax.php',
                            type: 'post',
                            data: {postid:postid,rating:value},
                            dataType: 'json',
                            success: function(data){
                                // Update average
                                var average = data['averageRating'];
                                $('#avgrating_'+postid).text(average);
                            }
                        });
                    }
                }
            });
        });
      
        </script>

</head>
<body>
    <?php 
    include 'nav.php';
    // Include the database configuration file  

    // Get image data from database 
    $result = $conn->query("SELECT * FROM art"); 
    $userid = get_current_user().getRealIpAddr();
    ?>    
    <?php if($result->num_rows > 0){ ?>  
        <h1><?php echo $userid?></h1>
        <div class="container-fluid">
        <div class="row">
            <?php while($row = mysqli_fetch_array($result)){ ?>   
                <?php 
                    $postid = $row['id'];

                    //userrating
                    $query = "SELECT * FROM art_rating WHERE artid=".$postid." and userid LIKE '$userid'";
                    $userresult = mysqli_query($conn,$query) or die(mysqli_error($conn));
                    $fetchRating = mysqli_fetch_array($userresult);
                    $rating = isset($fetchRating['rating']);

                    //average
                    $query = "SELECT ROUND(AVG(rating),1) as averageRating FROM art_rating WHERE artid=".$postid;
                    $avgresult = mysqli_query($conn,$query);
                    $fetchAverage = mysqli_fetch_array($avgresult);
                    $averageRating = $fetchAverage['averageRating'];

                    if($averageRating <= 0){
                        $averageRating = "No rating yet.";
                    }
                ?>
                    <div class="col-sm"> 
                    <div class="card1">
                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" />
                        <div class="content">
                            <h1><?php echo $row['art_name']; ?></h1>
                            <div class="post-action">
                            <!-- Rating -->
                            <select class='rating' id='rating_<?php echo $postid; ?>' data-id='rating_<?php echo $postid; ?>'>
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                            <div style='clear: both;'></div>
                            Average Rating : <span id='avgrating_<?php echo $postid; ?>'><?php echo $averageRating; ?></span>

                            <!-- Set rating -->
                            <script type='text/javascript'>
                            $(document).ready(function(){
                                $('#rating_<?php echo $postid; ?>').barrating('set',<?php echo $rating; ?>);
                            });
                            
                            </script>
                        </div>
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