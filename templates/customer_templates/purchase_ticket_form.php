<form name = "purchase_ticket" method = "post" action = "purchase_tickets.php" id = "purchase_form">
	<label> Purchase Tickets </label>
		<?php
		require('../templates/oci_query_header.php');

		$query = "SELECT airport_code, airport_name, city, country_name  
				  FROM Airport_LocatedIn";
		//execute it so that you can get all countries



</form>