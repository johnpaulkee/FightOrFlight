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
	echo '<form name="confirm" action="airline_templates/confirm_deletion.php" method="post" id="confirm_delete">';
	$query = "SELECT * FROM Plane_Owned_By p WHERE p.airline_code='".$airline_code."' AND p.plane_ID = '".$plane_ID."' AND p.plane_ID IN (SELECT plane_ID FROM Is_With) AND p.airline_code IN (SELECT airline_code FROM Is_With)";
	$result = executePlainSQL($query);
	if(($row = oci_fetch_row($result)) != false) {
		echo "<h3> This plane is scheduled to fly with tickets currently on the market. Retiring this plane will remove all tickets associated with this plane. Are you sure you want to continue?</h3>";
	}
	echo '<input type="submit" name="confirm" value="confirm">';
	echo '</form>';

	echo '<div id="formresult"></div>';
	echo '<script>

	$.post("airline_templates/confirm_deletion.php", { plane_ID: '.$plane_ID.', airline_code: '.$airline_code.' }, function(result) {
    alert("successfully posted key1=value1&key2=value2 to airline_templates/confirm_deletion.php");
	});

	
	$("#confirm_delete").submit(function() {

    var url = $(this).attr("action");

    $.ajax({
           type: "POST",
           url: url,
           data: $("#confirm_delete").serialize(),
           success: function(data)
           {	
           		alert("DELETED");
              $("#formresult").html(data);
           }
         });

    return false;
});
</script>';

}

?>