<?php
require('eci_query_header.php');
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");


  // Define user and pass
$capacity = ucfirst($_POST['plane']);
$price = ucfirst($_POST['price']);
$first_num = ucfirst($_POST['first_class']);
$first_price = ucfirst($_POST['first_class_price']);
$business_num = ucfirst($_POST['business']);
$business_price = ucfirst($_POST['business_price']);
$economy = $capacity - $first_num - $business_num;

// Connect Oracle...
if ($db_conn) {
  $k = 0;
  $s1 = 0;
  $s2 = "A";
  $s3 = 0;
  for(int i=0; i<$economy; i++){
    if($s2 == "A"){
      $s2="B";
    } else if ($s2 == "B"){
      $s2 = "C";
    } else if ($s2 == "C") {
      $s2 = "D";
    } else if ($s2 == "D"){
      $s2 = "E";
    } else if ($s2 == "E"){
      $s2 = "F";
    }
    if($k%6 == 0){
      $s1 = $s1 + 1;
      $s2 = "A";
    }
    $s3 = ($s3 + 1) % 10;
    $seat = $s1.$s2.$s3;
    $query = "INSERT INTO Tickets(seat, class, price) VALUES ('".$seat."', 'Economy', '".$price."')";
    $result = executePlainSQL($query);
  }
}

?>