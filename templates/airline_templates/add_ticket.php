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
  $query = "INSERT INTO Tickets airline_name, name from Airline_Headquartered_In where airline_name LIKE'%".$airline."%'";
  $result = executePlainSQL($query);
  printResult($result);
}

?>