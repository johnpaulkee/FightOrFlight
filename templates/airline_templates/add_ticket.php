<?php
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

$k = 0;
$s1 = 0;
$s2 = "A";
$s3 = 0;


function printResult($result) { //prints results from a select statement
  echo "<h3><center> Here are the available tickets that you can purchase: </center></h3>";

  echo "<table class = 'table table-striped'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>tID</th>";
  echo "<th>Seat</th>";
  echo "<th>Class</th>";
  echo "<th>Price</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  while (($row = oci_fetch_row($result)) != false) {
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "</td>";
    echo "<td>" . $row[3] . "</td>";
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

    function nextLetter($letter) {
      if($letter == "A") {
        $result = "B";
      } else if ($letter == "B") {
        $result = "C";
      } else if ($letter == "C"){
        $result = "D";
      } else if ($letter == "D") {
        $result = "E";
      } else if ($letter == "E") {
        $result = "F";
      } else if ($letter == "F") {
        $result = "G";
      } else if ($letter == "G") {
        $result = "H";
      } else if ($letter == "H") {
        $result = "I";
      } else if ($letter == "I") {
        $result = "J";
      } else {
        $result = "A";
      }
      return $result;
    }

    function generateSeat() {
      $s3 = ($s3+1)%10;
      if($s3 == 0){
        $s2 = nextLetter($s2);
       }
       if ($s2 == "J") {
        $s1 = ($s1 + 1)%10;
      }
       $seat = $s1.$s2.$s3;
       return $seat;
    }

// Connect Oracle...
if ($db_conn) {
  $query = "SELECT MAX(tID) FROM TICKET";
  $result = executePlainSQL($query);
  $row = oci_fetch_row($result);
  $primarykey=$row[0] + 1;
  for($i=0; $i<$economy; $i++){
    $seat = generateTicket();
    $primarykey = $primarykey + 1;
    $query = "INSERT INTO Ticket(tID, seat, class, price) VALUES ('".$primarykey."', '".$seat."', 'Economy', '".$price."')";
    $result = executePlainSQL($query);
  }
   for($i=0; $i<$first_num; $i++){
    $seat = generateSeat();
    $primarykey = $primarykey + 1;
    $query = "INSERT INTO Ticket(tID, seat, class, price) VALUES ('".$primarykey."', '".$seat."', 'First', '".$first_price."')";
    $result = executePlainSQL($query);
  }
  for($o=0; $i<$business_num; $i++){
    $seat = generateSeat();
    $primarykey = $primarykey + 1;
    $query = "INSERT INTO Ticket(tID, seat, class, price) VALUES ('".$primarykey."', '".$seat."', 'Business', '".$business_price."')";
    $result = executePlainSQL($query);
  }
  $query = "SELECT * FROM Ticket";
  $result = executePlainSQL($query);
  printResult($result);
}

?>