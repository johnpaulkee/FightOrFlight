<html>
 <head></head>
  <body>
  <?php
 	// Define user and pass
	$username = $_POST['myusername'];
 	$password = $_POST['mypassword'];
 	$type = $_POST['userType'];
 	$table = "";
 	$redirect = -1;

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

	if($type == "customer") {
		$table = "Customer_Login";
		$redirect=0;
	} else if ($type == "airlineemployee") {
		$table = "Airline_Employee_Login";
		$redirect=1;
	} else if ($type == "airline") {
		$table = "Airline_Login";
		$redirect=2;
	}

	if($table == ""){
		echo " ERROR: Login type not specified";
		header('Location: /~u8a9/FightOrFlight/templates/main_login.php');  
	} else {

	$query = "SELECT username FROM ".$table." WHERE username='".$username."' AND password='".$password."'";
	$result = executePlainSQL($query);
	echo "going into if";
	if(oci_fetch_row($result) == false){
		echo "Please re-enter your credentials";
		header('Location: /~u8a9/FightOrFlight/templates/main_login.php');  
	} else {
		do{
			echo $row[0];
			echo "success";
			if($redirect == 0){
				echo "redirecting to customer";
				//header('Location :/~u8a9/FightOrFlight/templates/customer.php');
			} else if ($redirect == 1){
				//header('Location :/~u8a9/FightOrFlight/templates/airline_employee.php');
				echo "redirecting to airline employee";
			} else if ($redirect == 2){
				echo "redirecting to airline";
				//header('Location :/~u8a9/FightOrFlight/templates/airline.php');
			}
		} while(($row = oci_fetch_row($result)) != false)
	}
	echo "debuggin";
}


 ?>
 </body>
 </html>