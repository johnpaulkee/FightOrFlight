<?php
$type = $_COOKIE['type'];
      if ($type != "airlineemployee") {
          header("Location: ../templates/not_authorized.html");
          die();
      }
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");


  // Define user and pass
$airlinename = $_POST['airlinename'];


function printResult($result) { //prints results from a select statement
  echo "<h3><center> Here are the details for your selected airport: </center></h3>";
  echo "<table class = 'table table-striped'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>Airline Code</th>";
  echo "<th>Airline Name</th>";
  echo "<th>Plane ID</th>";
  echo "<th>Plane Capacity</th>";
  echo "<th>Plane Company</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  while (($row = oci_fetch_row($result)) != false) {
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "</td>";
    echo "<td>" . $row[3] . "</td>";
    echo "<td>" . $row[4] . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
  echo $result;

}

function executePlainSQL($cmdstr) { 
      //echo "<br>running ".$cmdstr."<br>";
      $db_con = OCILogon("ora_i4u9a", "a34129122", "ug");
      $statement = OCIParse($db_con, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

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

// Connect Oracle...
if ($db_conn) {
  $query = "SELECT airline.airline_code, airline.airline_name,
  ,aircraft.plane_ID, aircraft.capacity, aircraft.company from Airline_Headquartered_In airline, Plane_Owned_By aircraft where airline.airline_name LIKE ='%".$airlinename."%' and aircraft.airline_code = airline.airline_code";
  $result = executePlainSQL($query);

  printResult($result);
}

?>