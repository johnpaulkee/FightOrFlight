<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");


  // Define user and pass
list($capacity, $planeID) = explode(",", $_POST['plane']);
$price = $_POST['price'];
$first_num = $_POST['first_class'];
$first_price = $_POST['first_class_price'];
$business_num = $_POST['business'];
$business_price = $_POST['business_price'];
$economy = $capacity - $first_num - $business_num;
$to = $_POST['to'];
$from = $_POST['from'];

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
      } else {
      }
      return $statement;
    }

    function nextLetter($letter) {
      if($letter == "A") {
        $letter = "B";
      } else if ($letter == "B") {
        $letter = "C";
      } else if ($letter == "C"){
        $letter = "D";
      } else if ($letter == "D") {
        $letter = "E";
      } else if ($letter == "E") {
        $letter = "F";
      } else if ($letter == "F") {
        $letter = "G";
      } else if ($letter == "G") {
        $letter = "H";
      } else if ($letter == "H") {
        $letter = "I";
      } else if ($letter == "I") {
        $letter = "J";
      } else {
        $letter = "A";
      }
      return $letter;
    }

    function generateSeat() {
      $GLOBALS['s3'] = (($GLOBALS['s3']+1)%10);
      if($GLOBALS['s3'] == 0){
        $GLOBALS['s2'] = nextLetter($GLOBALS['s2']);
      }
      if ($GLOBALS['s2'] == "J") {
        $GLOBALS['s1'] = (($GLOBALS['s1'] + 1)%10);
      }
      $return = $GLOBALS['s1'].$GLOBALS['s2'].$GLOBALS['s3'];
      return $return;
    }

// Connect Oracle...
    if ($db_conn) {
      $query = "SELECT MAX(tID) FROM TICKET";
      $result = executePlainSQL($query);
      $row = oci_fetch_row($result);
      echo ($row[0]);
      $primarykey=$row[0] + 1;
      $boardingpk = "SELECT MAX(boardingID) FROM Boarding_Pass_For_Flight";
      $bpkresult = executePlainSQL($boardingpk);
      $bpkrow = oci_fetch_row($bpkresult);
      $boardingprimary = $row[0];
      $flightpk = "SELECT MAX(flight_num) FROM Boarding_Pass_For_Flight";
      $fpkresult = executePlainSQL($flightpk);
      $fpkrow = oci_fetch_row($fpkresult);
      $flightprimary = $fpkrow[0];
      if ($capacity <= 40){
        $weight = 16;
      } else if ($capacity <= 80) {
        $weight = 19;
      } else {
        $weight = 23;
      }
      for($i=0; $i<$economy; $i++){
        $seat = generateSeat();
        echo $seat;
        $primarykey = $primarykey + 1;
        $boardingprimary = $boardingprimary + 1;
        $flightprimary = $flightprimary + 1;
        // $query = "INSERT INTO Ticket(tID, seat, class, price) VALUES ('".$primarykey."', '".$seat."', 'Economy', '".$price."')";
        // $result = executePlainSQL($query);
        // $query2 = "INSERT INTO Boarding_Pass_For_Flight VALUES ('".$boardingprimary."', '".$flightprimary."', '".$weight."', '".$seat."', '".$from."', '".$to."', ".$_COOKIE['id']."')";
        // $result2 = executePlainSQL($query2);
      //   $query3 = "INSERT INTO Add_Ticket VALUES ('".$primarykey."', '".$_COOKIE['id']."')";
      //   $result3 = executePlainSQL($query3);
      //   $query4 = "INSERT INTO Is_With VALUES ('".$boardingprimary."', '".$flightprimary."', '".$from."', '".$to."', '".$primarykey."', '".$planeID."', '".$_COOKIE['id']."', '".$_COOKIE['id']."')";
      //   $result4 = executePlainSQL($result4);
      }
      // $weight = $weight + 2;
  //  for($i=0; $i<$first_num; $i++){
  //   $seat = generateSeat();
  //   $primarykey = $primarykey + 1;
  //   $query = "INSERT INTO Ticket(tID, seat, class, price) VALUES ('".$primarykey."', '".$seat."', 'First', '".$first_price."')";
  //   $result = executePlainSQL($query);
  // }
  // $weight = $weight + 3;
  // for($i=0; $i<$business_num; $i++){
  //   $seat = generateSeat();
  //   $primarykey = $primarykey + 1;
  //   $query = "INSERT INTO Ticket(tID, seat, class, price) VALUES ('".$primarykey."', '".$seat."', 'Business', '".$business_price."')";
  //   $result = executePlainSQL($query);
  // }
      $query1 = "SELECT * FROM Ticket";
      $result1 = executePlainSQL($query1);
      printResult($result1);
      oci_commit($db_conn);
      OCILogoff($db_conn);
    }

    ?>