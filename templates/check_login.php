<html>
 <head></head>
  <body>
  <?php
 	// Define user and pass
	$username = $_POST['myusername'];
 	$password = $_POST['mypassword'];
 	$type = $_POST['userType'];
 	$table = "";

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
	} else if ($type == "airlineemployee") {
		$table = "Airline_Employee_Login";
	} else if ($type == "airline") {
		$table = "Airline_Login";
	}

	if($table == ""){
		echo " ERROR: Login type not specified";
	} else {

	$query = "SELECT username FROM ".$table." WHERE username = '".$username."' AND password = '".$password."'";
	$result = executePlainSQL($query);
	if(oci_fetch_row($result) == false){
		echo "Please re-enter your credentials";
		header('Location: /home/i/i4u9a/public_html/FightOrFlight/templates/main_login.php');  
	}
	while(($row = oci_fetch_row($result)) != false){
		echo $row[0];
	}


}


 ?>
 </body>
 </html>