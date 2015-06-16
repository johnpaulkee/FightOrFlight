<html>

<form>

	<label> Select Plane </label>
	<select class ="form-control">
		<?php
		$bd_conn = OCILogon("ora_i4u9a", "a34129122", "ug");
		$query = "SELECT plane_ID, capacity, company
				  FROM Airline_Headquartered_In a, Plane_Owned_By p
				  WHERE a.airline_code = p.airline_code"
		$statement = OCIParse($db_conn, $query);
		$result = OCIExecute($statement, OCI_DEFAULT);
		while(($row = oci_fetch_row($result)) != false) {
			$option = '<option value="'.$row[0].', '.$row[1].', '.$row[2].'</option>';
			echo($option);
		}
		oci_free_statement($statement);
		oci_close($conn);
		?>
	</select>
</form>

</html>