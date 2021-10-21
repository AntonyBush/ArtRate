<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "art_rate";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    session_start();

    if(!$conn){
            die("Unable to connect to the database due to the following error --> ".mysqli_connect_error());
    }
?>