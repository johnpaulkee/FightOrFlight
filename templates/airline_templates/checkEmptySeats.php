<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");


  // Define user and pass
echo $_POST['ahq'];
list($tsold,$capacity) = explode(",",$_POST['ahq']);
$percEmpty = 100 - (($tsold/$capacity) * 100);
echo $tsold;
echo $capacity;
echo $percEmpty;
echo "done";

  // echo "<h3><center> Here are the stats for your selected flight's empty seats: </center></h3>";
  // echo "<table class = 'table table-striped'>";
  // echo "<thead>";
  // echo "<tr>";
  // echo "<th>Number of Empty Seats</th>";
  // echo "<th>Tickets Sold</th>";
  // echo "<th>Percentage of Seats Empty</th>";
  // echo "</tr>";
  // echo "</thead>";
  // echo "<tbody>";
  // // while (($row = oci_fetch_row($result)) != false) {
  //   echo "<tr>";
  //   echo "<td>" . $tsold . "</td>";
  //   echo "<td>" . $capacity . "</td>";
  //   echo "<td>" . $percEmpty . "</td>";
  //   echo "</tr>";
  // // }
  // echo "</tbody>";
  // echo "</table>";

function printResult($result) { //prints results from a select statement
  echo "<h3><center> Here are the stats for your selected flight's empty seats: </center></h3>";
  echo "<table class = 'table table-striped'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>Number of Empty Seats</th>";
  echo "<th>Tickets Sold</th>";
  echo "<th>Percentage of Seats Empty</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  while (($row = oci_fetch_row($result)) != false) {
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $percEmpty . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";

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
  // $query = "UPDATE Airline_Headquartered_In SET name='".$newHq."' WHERE airline_code=".$acode."";
  // $result = executePlainSQL($query2);
  // printResult($result);
}

?>