<p> Find Cheapest Flight from Your Location </p>
<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");
$airport = $_POST['airport'];

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
	echo "<h3><center> Hello Customer, here are your details: </center></h3>";
	echo "<h3><center> This should be an update or something with Customer to the Credit Card </center> </h3>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>CustID</th>";
	echo "<th>Credit Card Number</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";
		echo "<td>" . $row[1] . "</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";

}

// Connect Oracle...
if ($db_conn) {
	$drop_view = "DROP VIEW outbound_tickets";
	$result0 = executePlainSQL($drop_view);
	$view_query = "CREATE VIEW outbound_tickets as SELECT t1.tID FROM Ticket t1, Comprised_Of c1 WHERE t1.tID = c1.tID AND c1.from_airport_code = '".$airport."'";
	$result1 = executePlainSQL($view_query);
	$drop_narrowed_view = "DROP VIEW cheap_tickets";
	$result2 = executePlainSQL($drop_narrowed_view);
	$create_view = "CREATE VIEW cheap_tickets AS SELECT MIN(t.price) as minPrice, t.tID FROM Ticket t, outbound_tickets o WHERE t.tID = o.tID GROUP BY t.tID";
	$result3 = executePlainSQL($create_view);
	$query = "SELECT MIN(minPrice) FROM cheap_tickets";
	$result4 = executePlainSQL($query);
	printResult($result4);
	// while(($row = oci_fetch_row($result)) != false){
	// 	echo "<p>".$row[0].", ".$row[1].", ".$row[2].", ".$row[4]."</p>";
	// 	echo "<br>";
	// }
}

?>
