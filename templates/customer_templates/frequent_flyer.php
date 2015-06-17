<?php
$type = $_COOKIE['type'];
    if ($type != "../templates/customer") {
      header("Location: not_authorized.html");
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
			OCIBindByName($statement, $bind, $val);
			unset ($val); 
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
	echo "<h3><center> This should be an update or something with Customer </center> </h3>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Cust_ID</th>";
	echo "<th>Airline_Code</th>";
	echo "<th>Points</th>";
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

if ($db_conn) {
	if (array_key_exists('reset', $_POST)) {
		echo "<br> dropping table <br>";
		executePlainSQL("Drop table tab1");

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
	$result = executePlainSQL("SELECT * from frequent_flyer");
	printResult($result);
}

//Commit to save changes...
OCILogoff($db_conn);
} else {
	echo "cannot connect";
$e = OCI_Error(); // For OCILogon errors pass no handle
echo htmlentities($e['message']);
}

?>
