<p> Find Cheapest Flight from Your Location </p>
<?php
$type = $_COOKIE['type'];
    if ($type != "customer") {
      header("Location: ../templates/not_authorized.html");
      die();
    }
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");
$city = $_POST['city'];

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

// Connect Oracle...
if ($db_conn) {
	echo '<form name="select_airport" method="post" action="../templates/customer_templates/find_cheapest_flights.php" id="find_cheap_flights">';
	$query = "SELECT DISTINCT airport_code FROM Airport_LocatedIn WHERE city='".$city."'";
	$result = executePlainSQL($query);
	while(($row = oci_fetch_row($result)) != false) {
		$input = '<input type="radio" name="airport" value="'.$row[0].'">'.$row[0];
		echo $input;
	}
	echo '<br>';
	echo '<button class = "btn btn-default" type="submit" name="submit"> select </button>';

	echo '<div id="formresult"></div>';
	echo '<script>

	
	$("#find_cheap_flights").submit(function() {

    var url = $(this).attr("action");

    $.ajax({
           type: "POST",
           url: url,
           data: $("#find_cheap_flights").serialize(),
           success: function(data)
           {	
              $("#formresult").html(data);
           }
         });

    return false;
});
</script>';
}

?>
