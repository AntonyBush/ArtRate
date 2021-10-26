<?php

include 'config.php';

// if(isset($_POST['query']))
// {
//   $output = '';
//   $query = "SELECT category FROM art WHERE category LIKE '%".$_POST["query"]."%'";
//   $result = mysqli_query($conn, $query);
//   $output = '<ul>';
//   if(mysqli_num_rows($result) > 0)
//   {
//     while($row = mysqli_fetch_array($result))
//     {
//       $output .= '<li>'.$row["category"].'<li>';
//     }
//   }
//   else{
//     $output .= '<li>Category Not Found</li>';
//   }
//   $output .= '</ul>';
//   echo $output;
// }



$r = $conn->query("SELECT DISTINCT(category) FROM art");
$a=[];
while ($row = mysqli_fetch_row($r)) {
    $a[] = $row[0]; 
} 

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
        $hint .= "<br/> $name";
      }
    }
  }
}

echo $hint === "" ? "no suggestion" : $hint;

?>