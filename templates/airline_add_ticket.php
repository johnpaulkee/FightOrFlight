<form name = "form2" method = "post" action="airline_templates/add_ticket.php" id="ticket_form">
	<label> Select Plane </label><br>
		<?php
		require('oci_query_header.php');
		$type = $_COOKIE['type'];
    	if ($type != "airline") {
      		header("Location: ../templates/not_authorized.html");
      		die();
    	}

		$query = "SELECT p.plane_ID, p.capacity, p.company, p.airline_code 
				  FROM Plane_Owned_By p
				  WHERE ".$_COOKIE['id']." = p.airline_code";
		$result = executePlainSQL($query);
		while(($row = oci_fetch_row($result)) != false) {
			$option = '<input type="radio" name="plane" value="'.$row[1].",".$row[0].'">'.$row[0].", ".$row[1].", ".$row[2].'<br>';
			echo $option;
		}
		?>
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
    <label>From           To</label><br>
    <?php
    	$query = "SELECT airport_code FROM Airport_LocatedIn";
    	$result = executePlainSQL($query);
    	echo $result;
    	while(($row = oci_fetch_row($result)) != false) {
			$from = '<input type="radio" name="from" value="'.$row[0].'">'.$row[0].'<br>';
			$to = '<input type="radio" name="to" value="'.$row[0].'">'.$row[0].'<br>';
			echo "<p>";
			echo "<div class = 'col-md-6'>";
			echo $from;
			echo "</div>";
			echo "<div class = 'col-md-6'>";
			echo $to;
			echo "</div>";
			echo "</p>";
		}
    ?> 
    <input type="submit" name="Submit" value="create">
</form>
<div id="formresult"></div>

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

