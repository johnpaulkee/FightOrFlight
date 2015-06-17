<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");

$startingpoint = $_POST['starting_point'];
$endingpoint = $_POST['ending_point'];

// echo "Output:";
// echo "<br>";
// echo $startingpoint;
// echo "<br>";
// echo $endingpoint;


function printResult($result) { //prints results from a select statement

	echo "<form name='purchase_tickets1' method='post' action='customer_templates/update_customer_tickets.php' id='purchase_ticket'>";

	while (($row = oci_fetch_row($result)) != false) {
		$option1 = '<input type="radio" name="purchase_choice" value="'.$row[0].'">'.$row[0].", ".$row[1].", $".$row[2].'<br>';
		echo $option1;
	}
	echo "</form>";
	// echo $result;
}


function printIntermediateResult($result) { //prints results from a select statement
	while (($row = oci_fetch_row($result)) != false) {
		$option1 = '<input type="radio" name="purchase_choice" value="'.$row[0].'">'.$row[0].", ".$row[1].", $".$row[2].", ".$row[3].", ".$row[4].", $".$row[5].", $".$row[6].'<br>';
		echo $option1;
	}
	echo "</form>";
	// echo $result;
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

// Connect Oracle...
if ($db_conn) {
	echo "<h3><center> Here are the available tickets that you can purchase: </center></h3>";
	$query1 = "SELECT c.from_airport_code, c.to_airport_code, t.price
			   FROM Comprised_Of c, Ticket t
			   WHERE from_airport_code = '$startingpoint' and 
			   		 to_airport_code = '$endingpoint' and 
			   		 t.tid = c.tid";
	$result1 = executePlainSQL($query1);
	printResult($result1);


	$query2 = "SELECT c1.from_airport_code, c1.to_airport_code, t1.price, c2.from_airport_code, c2.to_airport_code, t2.price, t1.price + t2.price 
		      FROM Comprised_Of c1, Comprised_Of c2, Ticket t1, Ticket t2 
		      WHERE c1.to_airport_code = c2.from_airport_code and 
		      	    c1.from_airport_code = '$startingpoint' and 
		      	    c1.tid = t1.tid and
		      	    c2.tid = t2.tid and 
		      	    c2.to_airport_code = '$endingpoint'";
	$result2 = executePlainSQL($query2);
	printIntermediateResult($result2);

	echo "<center> <button class='btn btn-default' type='submit' name='submit'> Purchase </button> </center>";

}
?>