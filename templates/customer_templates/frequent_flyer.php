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

function printFrequentFlyerData($result) { //prints results from a select statement
	echo "<p> User details: </p>";

	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Airline</th>"; 
	echo "<th>Points</th>";
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
	$query_freq_flyer = "SELECT a.airline_name, f.points
						   FROM customer_login cl, frequent_flyer f, Airline_Headquartered_In a
						   WHERE f.cust_ID = cl.cust_ID and
						   		 a.airline_code = f.airline_code and
								 cl.username = '".$_COOKIE['username']."'";
	$user_details = executePlainSQL($query_freq_flyer);
	printFrequentFlyerData($user_details);

	// CREATE TABLE Airline_Headquartered_In(
	// airline_code INTEGER,
	// airline_name VARCHAR2(255) NOT NULL,
	// name VARCHAR2(2airline_code55) NOT NULL,
	// PRIMARY KEY (),
	// FOREIGN KEY (name) REFERENCES Country(name)
}

//Commit to save changes...
OCILogoff($db_conn);
} else {
	echo "cannot connect";
$e = OCI_Error(); // For OCILogon errors pass no handle
echo htmlentities($e['message']);
}

?>
