<?php
$type = $_COOKIE['type'];
      if ($type != "airline") {
          header("Location: ../templates/not_authorized.html");
          die();
      }
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");


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
	echo "<h3><center> VIP: Customers who have travelled via all airlines </center></h3>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Customer Name</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}

$drop_view = "DROP VIEW allCustAirTickets";
$dropViewResult = executePlainSQL($drop_view);
	
$viewQuery ="CREATE VIEW allCustAirTickets as
			SELECT cp.cust_ID as custID, ahi.airline_code as aCode, ahi.airline_name as aName, cp.tID as tID
			FROM Airline_Headquartered_In ahi, Add_Ticket at, Customer_Purchase cp
			WHERE ahi.airline_code=at.airline_code AND at.tid=cp.tID";
$viewResult = executePlainSQL($viewQuery);
$query = "SELECT * FROM allCustAirTickets";
$result = executePlainSQL($query);
//printResult($result);

$mainQuery = 	"SELECT DISTINCT c.custName
				FROM allCustAirTickets a, Customer c
				WHERE c.cust_ID=a.custID AND 
						NOT EXISTS ((SELECT DISTINCT ahi.airline_code
											FROM Airline_Headquartered_In ahi)
											MINUS
											(SELECT DISTINCT a2.aCode
											FROM allCustAirTickets a2
											WHERE a.custID=a2.custID)
											)";
$res = executePlainSQL($mainQuery);
printResult($res);

oci_free_statement($viewResult);
oci_close($db_conn);
?>
