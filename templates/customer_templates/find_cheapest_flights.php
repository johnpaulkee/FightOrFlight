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

function executeBoundSQL($cmdstr, $list) {
/* Sometimes a same statement will be excuted for severl times, only
the value of variables need to be changed.
In this case you don't need to create the statement several times; 
using bind variables can make the statement be shared and just 
parsed once. This is also very useful in protecting against SQL injection. See example code below for       how this functions is used */

global $db_conn, $success;
$statement = OCIParse($db_conn, $cmdstr);

if (!$statement) {
	echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
	$e = OCI_Error($db_conn);
	echo htmlentities($e['message']);
	$success = False;
}

foreach ($list as $tuple) {
	foreach ($tuple as $bind => $val) {
//echo $val;
//echo "<br>".$bind."<br>";
		OCIBindByName($statement, $bind, $val);
unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

}
$r = OCIExecute($statement, OCI_DEFAULT);
if (!$r) {
	echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
echo htmlentities($e['message']);
echo "<br>";
$success = False;
}
}

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

// Connect Oracle...
if ($db_conn) {
	$query = "SELECT MIN(t.price) as minPrice, t.tID, c.to_airport_code, a.city 
	FROM Ticket t, Comprised_Of c, Airport_LocatedIn a 
	WHERE t.tID = c.tID AND a.airport_code = c.to_airport_code
	GROUP BY t.price
	HAVING c.from_airport_code = '".$airport."'" ;
	$result = executePlainSQL($query);
	echo $result;
	// while(($row = oci_fetch_row($result)) != false){
	// 	echo "<p>".$row[0].", ".$row[1].", ".$row[2].", ".$row[4]."</p>";
	// 	echo "<br>";
	// }
	}

?>
