<form name = "form2" method = "post" action="../templates/airline_templates/add_ticket.php" id="ticket_form">
	<label> Select Plane </label>
	<select class="form-control">
		<?php
		require('oci_query_header.php');

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