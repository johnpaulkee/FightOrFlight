<?php
$type = $_COOKIE['type'];
    if ($type != "customer") {
      header("Location: ../templates/not_authorized.html");
      die();
    }
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");

$startingpoint = $_POST['starting_point'];
$endingpoint = $_POST['ending_point'];

function printResult($result) { //prints results from a select statement
	echo "<p> Tickets that are not bought yet </p>";
	echo "<table class = 'table table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>tID</th>"; 
	echo "<th>cust_ID</th>";
	echo "<th>payment_total</th>";
	echo "<th>payment_type</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";
		echo "<td>" . $row[1] . "</td>";
		echo "<td>" . $row[2] . "</td>";
		echo "<td>" . $row[3] . "</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}

function printDirectPurchase($result) { //prints results from a select statement
	echo "<form name='purchase_tickets1' method='post' action='customer_templates/update_customer_tickets.php' id='purchase_ticket'>";
	echo "Here are the list of direct flights <br>";
	while (($row = oci_fetch_row($result)) != false) {
		$from = $row[0];
		$to = $row[1];
		$price = $row[2];
		$tID = $row[3];
		$custID = $row[4];

		$option = '<input type="radio" name="purchase_choice" value="'.$tID.'|'.$price.'|'.$custID.'">'.$from.', '.$to.', '.$price.', '.$tID;
		echo $option;
		echo $custID;
	}
	echo "<br>";
	echo "<button class='btn btn-default' type='submit' name='submit'> Purchase Direct Flight </button>";
	echo "</form>";
}
function printIndirectPurchase($result) { //prints results from a select statement
	echo "<form name='purchase_tickets2' method='post' action='customer_templates/update_customer_tickets.php' id='purchase_ticket'>";
	echo "Here are the list of indirect flights <br>";
	while (($row = oci_fetch_row($result)) != false) {
		$from1 = $row[0];
		$to1 = $row[1];
		$price1 = $row[2];
		$from2 = $row[3];
		$to2 = $row[4];
		$price2 = $row[5];
		$sum = $row[6];
		$tid1 = $row[7];
		$tid2 = $row[8];
		$custID = $row[9];
		$option = '<input type="radio" name="ticket_id" value="'.$tid1.'|'.$tid2.'|'.$sum.'|'.$custID.'">'.$from1.", ".$to1.", $".$price1.", ".$from2.", ".$to2.", $".$price2.", $".$sum.'<br>';
		echo $option;
		echo $custID;
	}

	echo "<button class='btn btn-default' type='submit' name='submit'> Purchase Indirect Flight </button>";	
	echo "</form>";
}

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
    } else {
    }
    return $statement;
}

// Connect Oracle...
if ($db_conn) {
	$username = $_COOKIE['username'];
	echo "<h3><center> Here are the available tickets that you can purchase: </center></h3>";
	// Do a query to find tickets that are not bought yet
	$drop_unpurchased_view = "DROP VIEW unpurchased_tickets";
	$execute_drop_unpurchased_view = executePlainSQL($drop_unpurchased_view);
	$create_unpurchased_view = "CREATE VIEW unpurchased_tickets AS 
					 SELECT * 
					 FROM Ticket t
					 WHERE t.tID NOT IN (SELECT c.tID
					 	                 FROM Customer_Purchase c)";
	$execute_unpurchased_view = executePlainSQL($create_unpurchased_view);
	$not_in_query = "SELECT * FROM unpurchased_tickets";
	$result = executePlainSQL($not_in_query);
	printResult($result);

	//Direct Flights
	$direct_query = "SELECT co.from_airport_code, co.to_airport_code, ut.price, ut.tID, c.cust_ID
			   FROM Comprised_Of co, unpurchased_tickets ut, Customer_Login cl, Customer c
			   WHERE co.from_airport_code = '$startingpoint' and 
			   		 co.to_airport_code = '$endingpoint' and 
			   		 ut.tid = co.tid and
			   		 cl.username = '$username' and c.cust_ID = cl.cust_ID";
	$direct = executePlainSQL($direct_query);
	printDirectPurchase($direct);

	//Indirect Flights
	$indirect_query = "SELECT c1.from_airport_code, c1.to_airport_code, t1.price, c2.from_airport_code, c2.to_airport_code, t2.price, t1.price + t2.price, t1.tID, t2.tID, c.cust_ID 
		      FROM Comprised_Of c1, Comprised_Of c2, unpurchased_tickets t1, unpurchased_tickets t2, Customer_Login cl, Customer c 
		      WHERE c1.to_airport_code = c2.from_airport_code and 
		      	    c1.from_airport_code = '$startingpoint' and 
		      	    c1.tid = t1.tid and
		      	    c2.tid = t2.tid and 
		      	    c2.to_airport_code = '$endingpoint' and 
		      	    cl.username = '$username' and c.cust_ID = cl.cust_ID";
	$indirect = executePlainSQL($indirect_query);
	printIndirectPurchase($indirect);
}
?>