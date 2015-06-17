<form action="./airline_templates/add_ticket.php" id="ticket_form">
	<label> Select Plane </label>
	<select class="form-control">
		<?php
			function executePlainSQL($cmdstr) { 
			//echo "<br>running ".$cmdstr."<br>";
			$db_con = OCILogon("ora_i4u9a", "a34129122", "ug");
			$statement = OCIParse($db_con, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

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

		$query = "SELECT plane_ID, capacity, company, p.airline_code 
				  FROM Airline_Headquartered_In a, Plane_Owned_By p
				  WHERE a.airline_code = p.airline_code";
		$result = executePlainSQL($query);
		echo $result;
		while(($row = oci_fetch_row($result)) != false) {
			$option = '<option name="plane" value="'.$row[1].'">'.$row[0].", ".$row[1].", ".$row[2].'</option>';
			echo $option;
		}
		oci_free_statement($statement);
		oci_close($con);
		?>
	</select>
	<label>Economy Ticket Price</label>
	<p>$<input type="number" name="price"></p>
	<label>Number of First Class tickets</label><br>
	<input type="number" name="first_class"><br>
	<label>First Class Ticket Price</label><br>
	<p>$
	<input type="number" name="first_class_price"></p>
	<label>Number of Business tickets</label><br>
	<input type="number" name="business"><br>
	<label>Business Ticket Price</label><br>
    <p>$
    <input type="number" name="business_price"></p>
    <input type="submit" name="Submit" value="create">
</form>

<script>
	
	$("#ticket_form").submit(function() {

    var url = $(this).attr("action"); // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#ticket_form").serialize(), // serializes the form's elements.
           success: function(data)
           {	
           		alert("SUCCESS");
              $("#formresult").html(data); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
</script>