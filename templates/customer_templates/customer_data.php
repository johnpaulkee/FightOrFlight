<?php
$type = $_COOKIE['type'];
if ($type != "customer") {
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
	echo "<p> User details: </p>";

	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Name</th>"; 
	echo "<th>Username</th>";
	echo "<th>Password</th>";
	echo "<th>Blacklisted</th>";
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

function printTicketDetails($result) {
	echo "<p> Your Tickets and it's Plane Details </p>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Ticket ID</th>"; 
	echo "<th>Seat</th>"; 
	echo "<th>Class</th>"; 
	echo "<th>From</th>"; 
	echo "<th>To</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	// "SELECT t.tID, t.seat, t.class, bpff.from_airport_code, bpff.to_airport_code
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

function printTicketAndPlaneDetails($result) { //prints results from a select statement
	echo "<p> Your Tickets and it's Plane Details </p>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Ticket ID</th>"; 
	echo "<th>Seat</th>"; 
	echo "<th>Class</th>"; 
	echo "<th>From</th>"; 
	echo "<th>To</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	// "SELECT t.tID, t.seat, t.class, bpff.from_airport_code, bpff.to_airport_code
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

function printCredCardDetails($result) { //prints results from a select statement
	echo "<p> Your Credit Card Info </p>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Credit Card</th>"; 
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

function printBagTagDetails($result) { //prints results from a select statement
	echo "<p> Your Bag Tag Info </p>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>BagTag ID</th>"; 
	echo "<th>Weight</th>"; 
	echo "<th>Source Airline Code</th>"; 
	echo "<th>Dest Airline Code</th>"; 
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	//bt.bID, lr.weight, btlsf.source_airport_code, btlsf.destination_airport_code
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
// Connect Oracle...
if ($db_conn) {

	if (array_key_exists('reset', $_POST)) {
// Drop old table...
		echo "<br> dropping table <br>";
		executePlainSQL("Drop table tab1");

// Create new table...
		echo "<br> creating new table <br>";
		executePlainSQL("create table tab1 (nid number, name varchar2(30), primary key (nid))");
		OCICommit($db_conn);

	} else
	if (array_key_exists('insertsubmit', $_POST)) {
//Getting the values from user and insert data into the table
		$tuple = array (
			":bind1" => $_POST['insNo'],
			":bind2" => $_POST['insName']
			);
		$alltuples = array (
			$tuple
			);
		executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $alltuples);
		OCICommit($db_conn);

	} else
	if (array_key_exists('updatesubmit', $_POST)) {
// Update tuple using data from user
		$tuple = array (
			":bind1" => $_POST['oldName'],
			":bind2" => $_POST['newName']
			);
		$alltuples = array (
			$tuple
			);
		executeBoundSQL("update tab1 set name=:bind2 where name=:bind1", $alltuples);
		OCICommit($db_conn);

	} else
	if (array_key_exists('dostuff', $_POST)) {
// Insert data into table...
		executePlainSQL("insert into tab1 values (10, 'Frank')");
// Inserting data into table using bound variables
		$list1 = array (
			":bind1" => 6,
			":bind2" => "All"
			);
		$list2 = array (
			":bind1" => 7,
			":bind2" => "John"
			);
		$allrows = array (
			$list1,
			$list2
			);
executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $allrows); //the function takes a list of lists
// Update data...
//executePlainSQL("update tab1 set nid=10 where nid=2");
// Delete data...
//executePlainSQL("delete from tab1 where nid=1");
OCICommit($db_conn);
}

if ($_POST && $success) {
	header("location: oracle-test.php");
} else {
	// Customer details
	$query_user_details = "SELECT c.custName, cl.username, cl.password, c.blacklisted 
	FROM customer_login cl, customer c 
	WHERE c.cust_ID = cl.cust_ID and cl.username = '".$_COOKIE['username']."'";
	$user_details = executePlainSQL($query_user_details);
	printResult($user_details);

	// Credit Card Details
	$drop_cred_view = "DROP VIEW cred_card_details";
	$drop_cred_result = executePlainSQL($drop_cred_view);
	$create_cred_view = "CREATE VIEW cred_card_details as  
	SELECT c.credit_card_number 
	FROM customer c, customer_login cl 
	WHERE c.cust_ID = cl.cust_ID and cl.username = '".$_COOKIE['username']."'";
	$cred_view_result = executePlainSQL($create_cred_view);
	$query = "SELECT credit_card_number FROM cred_card_details";
	$cred_card = executePlainSQL($query);
	printCredCardDetails($cred_card);

	// Ticket and Other Details
	$query_tickets =   "SELECT t.tID, t.seat, t.class, bpff.from_airport_code, bpff.to_airport_code
						FROM Customer_Login cl, Customer c, Customer_Purchase cp, Ticket t, Comprised_of co, Boarding_Pass_For_Flight bpff
						WHERE cl.cust_ID = c.cust_ID and
							  c.cust_ID = cp.cust_ID and
							  cp.tID = t.tID and
							  co.tID = t.tID and
							  co.boarding_ID = bpff.boarding_ID and
							  co.flight_num = bpff.flight_num and
							  co.from_airport_code = bpff.from_airport_code and
							  co.to_airport_code = bpff.to_airport_code and
							  cl.username = '".$_COOKIE['username']."'";

	$tickets_planes = executePlainSQL($query_tickets);
	printTicketAndPlaneDetails($tickets_planes);

	// Bag tag
	   $query_bagtag = "SELECT blsf.bt_id, blsf.weight, blsf.source_airport_code, blsf.destination_airport_code
						FROM Customer_Login cl, Customer c, Customer_Purchase cp, Ticket t, Is_Issued ii, BagTag_Luggage_StartD_FinalD blsf
						WHERE cl.cust_ID = c.cust_ID and
							  c.cust_ID = cp.cust_ID and
							  cp.tID = t.tID and
							  ii.tID = t.tID and 
							  ii.bID = blsf.bt_ID and
							  cl.username = '".$_COOKIE['username']."'";	   

	$bagtag = executePlainSQL($query_bagtag);
	printBagTagDetails($bagtag);
}

//Commit to save changes...
OCILogoff($db_conn);
} else {
	echo "cannot connect";
$e = OCI_Error(); // For OCILogon errors pass no handle
echo htmlentities($e['message']);
}

?>
