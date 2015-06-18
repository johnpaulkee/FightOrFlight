<form name="retire_plane" action="airline_templates/delete_plane.php" method="post" id="delete_plane">
	<label> Which plane would you like to retire? </label><br>
	<?php
		$type = $_COOKIE['type'];
    	if ($type != "airline") {
     	header("Location: ../templates/not_authorized.html");
      	die();

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

      	$query = "SELECT * FROM Plane_Owned_By WHERE airline_code = '".$_COOKIE['id']."'";
      	$result = executePlainSQL($query);
      	echo $result;
      	echo "peepeepoopoo";
      	echo '<input type="submit" name="submit" value="retire">';
      	while(($row = oci_fetch_row($result)) != false) {
      		$input = '<input type="radio" name="plane" value="'.$row[0].','.$row[1].'">'.$row[1].', '.$row[2].', '.$row[3];
      		echo $input;
      	}
    }
	?>
	<input type="submit" name="submit" value="retire">
</form>