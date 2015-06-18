<?php
$type = $_COOKIE['type'];
if ($type != "customer") {
	header("Location: ../templates/not_authorized.html");
	die();
}
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");
$values = $_POST['purchase_choice'];
list($val1, $val2, $val3, $val4, $val5) = explode("|", $values);

function printResult($result) { //prints results from a select statement
	echo "<p> Purchasing Your Ticket </p>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>tID</th>"; 
	echo "<th>cust_ID</th>";
	echo "<th>payment_total</th>";
	echo "<th>payment_type</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";
		echo "<td>" . $row[1] . "</td>";
		echo "<td>" . $row[2] . "</td>";
		echo "<td>" . $row[3] . "</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}

function executePlainSQL($cmdstr) { 
	$db_con = OCILogon("ora_i4u9a", "a34129122", "ug");
	$statement = OCIParse($db_con, $cmdstr);
	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}
	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement);
		echo htmlentities($e['message']);
		$success = False;
	} else {}
	return $statement;
}

if ($db_conn) {
	// Direct Flights
	if ($val4 == '') {
		$purchase_query = "INSERT INTO Customer_Purchase
		VALUES ('$val1', '$val3', '$val2', 'Credit Card')";
		$purchase_result = executePlainSQL($purchase_query);
		oci_commit($db_conn);
	}
	// Indirect Flights
	else {
		echo "val1".$val1."<br>"; // tid1
		echo "val2".$val2."<br>"; // tid2
		echo "val3".$val3."<br>"; // price1
		echo "val4".$val4."<br>"; // price2
		echo "val5".$val5."<br>"; // custID
		
		$first_purchase_query = "INSERT INTO Customer_Purchase
						   VALUES ('$val1', '$val5', '$val3', 'Credit Card')";
		$purchase_result = executePlainSQL($first_purchase_query);
		oci_commit($db_conn);

		$second_purchase_query = "INSERT INTO Customer_Purchase
						   VALUES ('$val2', '$val5', '$val4', 'Credit Card')";
		$purchase_result = executePlainSQL($second_purchase_query);
		oci_commit($db_conn);
	}
}
?>