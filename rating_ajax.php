<?php

include "config.php";

$userid = 4;
$postid = $_POST['postid'];
$rating = $_POST['rating'];

// Check entry within table
$query = "SELECT COUNT(*) AS cntpost FROM art_rating WHERE artid=".$postid." and userid=".$userid;

$result = mysqli_query($conn,$query);
$fetchdata = mysqli_fetch_array($result);
$count = $fetchdata['cntpost'];

if($count == 0){
    $insertquery = "INSERT INTO art_rating(userid,artid,rating) values(".$userid.",".$postid.",".$rating.")";
    mysqli_query($conn,$insertquery);
}else {
    $updatequery = "UPDATE art_rating SET rating=" . $rating . " where userid=" . $userid . " and arttid=" . $postid;
    mysqli_query($conn,$updatequery);
}


// get average
$query = "SELECT ROUND(AVG(rating),1) as averageRating FROM art_rating WHERE artid=".$postid;
$result = mysqli_query($conn,$query) or die(mysqli_error());
$fetchAverage = mysqli_fetch_array($result);
$averageRating = $fetchAverage['averageRating'];

$return_arr = array("averageRating"=>$averageRating);

echo json_encode($return_arr);