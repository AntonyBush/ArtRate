<?php

include 'config.php';

$r = $conn->query("SELECT category FROM art");
$a=[];
while ($row = mysqli_fetch_row($r)) {
    $a[] = $row[0]; 
}

// $a = array("Agra","Ahmedabad","Aurangabad","Bangalore","Bhopal","Bhubabneshwar","Chennai","Coimbatore","Chandigarh",
// "Dehradun","Dindigul","Erode","Faridabad","Gandhinagar","Gangtok","Guwahati","Haridwar","Hyderabad","Indore","Imphal","Jaipur","Kalyan",
// "Kolkata","Kochi","Lucknow","Mumbai","Mangalore","Nagpur","Nashik","Panvel","Patna","Raipur","Ranchi","Shimla","Solapur",
// "Thiruvananthapuram","Tirupati","Udupi","Vadodara","Varanasi");

$q = $_REQUEST["q"];

$hint = "";

if ($q !== "") {
  $q = strtolower($q);
  $len=strlen($q);
  foreach($a as $name) {
    if (stristr($q, substr($name, 0, $len))) {
      if ($hint === "") {
        $hint = $name;
      } else {
        $hint .= ", $name";
      }
    }
  }
}

echo $hint === "" ? "no suggestion" : $hint;