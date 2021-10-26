<?php include 'config.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  
  <link rel="stylesheet" href="styles/main.css">
  
  <link href='jquery-bar-rating-master/dist/themes/fontawesome-stars.css' rel='stylesheet' type='text/css'>
  <link rel="icon" href="images/art-word.jpg" type="image/x-icon">
  
  <title>Art Rate</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

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

  <style>
    body{
          background-image:  url('images/index-bg2.jpg');     
          background-size: cover;
          
      }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <form action="index.php" method="get">
      <div class="input-group" style="margin-top:25px; width:23.5%; margin-left: 20px;">
          <div class="input-group-prepend">
              <button class="btn btn-primary" type="submit" name='filt'>Filter</button>
          </div>
          <select class="custom-select" id="inputGroupSelect03" name='filter'>
              <option disabled selected>Select Filter</option>
              <option value="Most Rated">Most Rated</option>
              <option value="Least Rated">Least Rated</option>
              <option value="New">New</option>
          </select>
      </div>
  </form>
  <?php
    if (isset($_GET['filt'])){
      $f = $_GET['filter'];
      if($f=="Most Rated"){
          $result = $conn->query("SELECT * FROM art ORDER BY rating DESC");  
      }
      else if($f=="Least Rated"){
          $result = $conn->query("SELECT * FROM art ORDER BY rating"); 
      }
      else if($f=="New"){
          $result = $conn->query("SELECT * FROM art ORDER BY uploaded_date DESC"); 
      }
      else{
          $result = $conn->query("SELECT * FROM art"); 
      }
    }
    else{
        $result = $conn->query("SELECT * FROM art"); 
    }
    $userid = get_current_user().getRealIpAddr();
  ?>
  <?php if($result->num_rows > 0){ ?>  
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
          <div class="col-lg-3"> 
            <div class="card1">
              <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" />
              <div class="content text-center">
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
                  <span style="font-size:20px;">Average Rating : <span id='avgrating_<?php echo $postid; ?>'><?php echo $averageRating; ?></span> </span>

                  <!-- Set rating -->
                  <script type='text/javascript'>
                    $(document).ready(function(){
                        $('#rating_<?php echo $postid; ?>').barrating('set',<?php echo $rating; ?>);
                    });
                  
                  </script>
                  </div>
                <a class="text-decoration-none" style="font-size: 30px; color: white; text-shadow: 2px 2px 10px rgb(129, 29, 211);" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='white'" href="view_art.php?id= <?php echo $row['id'] ;?>">Click to View</a>
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