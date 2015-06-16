<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");

  // Define user and pass
$airline = ucfirst($_POST['airlinename']);

function executePlainSQL($cmdstr) { 
  //echo "<br>running ".$cmdstr."<br>";
  global $db_conn, $success;
  $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

  if (!$statement) {
    echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
    $e = OCI_Error($db_conn); // For OCIParse errors pass the       
    // connection handle
    echo htmlentities($e['message']);
    $success = False;
  }

  $r = OCIExecute($statement, OCI_DEFAULT);
  if (!$r) {
    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
    $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
    echo htmlentities($e['message']);
    $success = False;
  } else {}
  return $statement;
}

function printResult($result) { //prints results from a select statement
  echo "<h3><center> Here are the available tickets that you can purchase: </center></h3>";

  echo "<table class = 'table table-striped'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>tID</th>";
  echo "<th>Seat Location</th>";
  echo "<th>Class</th>";
  echo "<th>Price</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";

}

// Connect Oracle...
if ($db_conn) {
  $query = "SELECT airline_code, airline_name, name from Airline_Headquartered_In where airline_name LIKE'%".$airline."%'";
  $result = executePlainSQL($query);
  printResult($result);
}

?>