<?php
$type = $_COOKIE['type'];
      if ($type != "airline") {
          header("Location: ../templates/not_authorized.html");
          die();
      }
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");


  // Define user and pass
$empid = $_POST['employeeid'];
$discval = $_POST['discountvalue'];
echo "Vals should be here";

echo $empid;
echo $discval;

function printResult($result) { //prints results from a select statement
  echo "<h3><center> Here are the details for your selected airport: </center></h3>";
  echo "<table class = 'table table-striped'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>ID</th>";
  echo "<th>Employee Name</th>";
  echo "<th>Discount</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  while (($row = oci_fetch_row($result)) != false) {
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "%</td>";
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
  $query = "UPDATE Airline_Employee_Employed_With SET discounts='".$discval."' WHERE employeeID=".$empid."";

  $query2 = "SELECT employeeID, employee_name, discounts FROM Airline_Employee_Employed_With WHERE employeeID=".$empid."";
  $resultalter = executePlainSQL($query);
  oci_commit(db_conn);
  $result = executePlainSQL($query2);
  printResult($result);
}

?>