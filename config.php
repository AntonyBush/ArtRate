<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "art_rate";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    function get_current_user_id() {
        if ( ! function_exists( 'wp_get_current_user' ) ) {
            return 0;
        }
        $user = wp_get_current_user();
        return ( isset( $user->ID ) ? (int) $user->ID : 0 );
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
    if(!$conn){
            die("Unable to connect to the database due to the following error --> ".mysqli_connect_error());
    }
?>