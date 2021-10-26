<?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "art_rate";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);

        if(!$conn){
                die("Unable to connect to the database due to the following error --> ".mysqli_connect_error());
        }
        function getRealIpAddr()
        {
                if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
                {
                        $ip=$_SERVER['HTTP_CLIENT_IP'];
                }
                        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
                {
                        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                else
                {
                        $ip=$_SERVER['REMOTE_ADDR'];
                }
                return $ip;
        }
?>