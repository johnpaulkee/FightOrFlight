<p> Your Most Loyal Customers Are </p>

<?php
$type = $_COOKIE['type'];
    if ($type != "airline") {
      header("Location: ../templates/not_authorized.html");
      die();
    }
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");
$method = $_POST['method'];

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
		echo "<td>" . $row[2] . "</td>";
		echo "<td>" . $row[3] . "</td>";
		echo "<td>" . $row[4] . "</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";

}

function createTable($entry){
	echo "<p>Your most loyal customers are: </p>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>cust_ID</th>";
	echo "<th>".$method."</th>";
	echo "<th>custName</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	while(($row = oci_fetch_row($entry)) != false){
		$query = "SELECT custName FROM Customer c WHERE c.cust_ID = '".$row[1]."'";
		$result = executePlainSQL($query);
		while(($row2 = oci_fetch_row($result)) != false) {
			echo "<tr>";
			echo "<td>" . $row[1] . "</td>";
			echo "<td>" . $row[0] . "</td>";
			echo "<td>" . $row2[0] . "</td>";
			echo "</tr>";
		}
	}
}

// Connect Oracle...
if ($db_conn) {
	$dropview = "DROP VIEW valuableCustomers";
	$dropresult = executePlainSQL($dropview);
	$createview = "CREATE VIEW valuableCustomers AS 
				   SELECT COUNT(t.tID) as num_tickets, SUM(t.price) as revenue, c.cust_ID
				   FROM Customer c, Customer_Purchase cp, Ticket t, Add_Ticket at 
				   WHERE c.cust_ID = cp.cust_ID AND 
				   		 cp.tID = t.tID AND
				   		 t.tID = at.tID AND
				   		 at.airline_code = '".$_COOKIE['id']."'
				   GROUP BY c.cust_ID";
	$viewresult = executePlainSQL($createview);
	echo ($viewresult);
	if($method == "quantity") {
		$query = "SELECT num_tickets, cust_ID FROM valuableCustomers v1 WHERE v1.num_tickets >= ALL (SELECT num_tickets FROM valuableCustomers)";
	} else {
		$query = "SELECT revenue, cust_ID FROM valuableCustomers v1 WHERE v1.revenue >= ALL (SELECT revenue FROM valuableCustomers)";
	}
	$result = executePlainSQL($query);
	createTable($result);
	//$query = "SELECT cust_ID, custName FROM Customer c WHERE c.cust_ID IN"
}

?>