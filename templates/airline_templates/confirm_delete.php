<?php
$type = $_COOKIE['type'];
    if ($type != "airline") {
      header("Location: ../templates/not_authorized.html");
      die();
    }
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");
$values = $_POST['plane'];
list($plane_ID, $airline_code) = explode(",", $values);

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
// Connect Oracle...
if ($db_conn) {
	echo "plane_ID";
	echo $plane_ID;
	echo "airline_code";
	echo $airline_code;
	$query1 = "SELECT capacity FROM Plane_Owned_By WHERE airline_code ='".$airline_code."' AND plane_ID = '".$plane_ID."'";
	echo $query1;
	$result1 = executePlainSQL($query1);
	$row = oci_fetch_row($result1);
	echo "row:";
	echo $row;
	if($row != false){
		$query2 = "DELETE FROM Plane_Owned_By p WHERE p.airline_code ='".$airline_code."' AND p.plane_ID = '".$plane_ID."'";
		echo $query2;
		$result2 = executePlainSQL($query2);
		oci_commit($db_conn);
		if($row[0] <= 40){
			$query3 = "DELETE FROM Low_Capacity WHERE airline_code = '".$airline_code."' AND plane_ID = '".$plane_ID."'";
			echo $query3;
			$result3 = executePlainSQL($query3);
			oci_commit($db_conn);
			$query4 = "DELETE FROM Regional_Flights WHERE airline_code = '".$airline_code."' AND plane_ID = '".$plane_ID."'";
			echo $query4;
			$result4 = executePlainSQL($query4);
			oci_commit($db_conn);
		} else {
			$query3 = "DELETE FROM High_Capacity WHERE airline_code = '".$airline_code."' AND plane_ID = '".$plane_ID."'";
			echo $query3;
			$result3 = executePlainSQL($query3);
			oci_commit($db_conn);
			$query4 = "DELETE FROM Long_Distance_Flights WHERE airline_code = '".$airline_code."' AND plane_ID = '".$plane_ID."'";
			echo $query4;
			$result4 = executePlainSQL($query4);
			oci_commit($db_conn);
		}
		$query5 = "DELETE FROM Is_With WHERE plane_airline_code = '".$airline_code."' AND plane_ID = '".$plane_ID."'";
		echo $query5;
		$result5 = executePlainSQL($query5);
		oci_commit($db_conn);
	}
	oci_commit($db_conn);
	OCILogoff($db_conn);
}

?>