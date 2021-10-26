<?php
sleep(1);
include 'config.php';
if (isset($_POST['request'])){
    $f = $_POST['request'];
    if($f==1){
        $result = $conn->query("SELECT * FROM art ORDER BY rating DESC");  
    }
    else if($f==2){
        $result = $conn->query("SELECT * FROM art ORDER BY rating"); 
    }
    else if($f==3){
        $result = $conn->query("SELECT * FROM art ORDER BY uploaded_date DESC"); 
    }
    else{
        $result = $conn->query("SELECT * FROM art"); 
    }
  }
  else{
      $result = $conn->query("SELECT * FROM art"); 
  }

?>