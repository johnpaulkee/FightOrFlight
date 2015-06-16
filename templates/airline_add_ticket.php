<form>

	<label> Select Plane </label>
	<select class="form-control">
		<?php
		$bd_conn = OCILogon("ora_i4u9a", "a34129122", "ug");
		$query = "SELECT *
				  FROM Airline_Headquartered_In a";
		$statement = OCIParse($db_conn, $query);
		$result = OCIExecute($statement, OCI_DEFAULT);
		while(($row = oci_fetch_row($statement)) != false) {
			$option = '<option value="'.$row[3].$row[0].'">'.$row[0].$row[1].$row[2].'</option>';
			echo($option);
		}
		oci_free_statement($statement);
		oci_close($conn);
		?>
	</select>
</form>