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
		$id = "cust_ID";
		$redirect=0;
	} else if ($type == "airlineemployee") {
		$table = "Airline_Employee_Login";
		$id = "employeeID, airline_code";
		$redirect=1;
	} else if ($type == "airline") {
		$table = "Airline_Login";
		$id = "airline_code";
		$redirect=2;
	}

	if($table == ""){
		echo " ERROR: Login type not specified";
		header('Location: ../templates/main_login.php');  
	} else {

	$query = "SELECT ".$id." FROM ".$table." WHERE username='".$username."' AND password='".$password."'";
	$result = executePlainSQL($query);
	if(($row = oci_fetch_row($result)) == false){
		echo "Please re-enter your credentials";
		header('Location: ../templates/main_login.php');  
	} else {
		$cookie_name = "username";
		$cookie_value = $username;
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/');
		$cookie_type_n = "type";
		$cookie_type_v = $type;
		setcookie($cookie_type_n, $cookie_type_v, time() + (86400 * 30), '/');
		do{
			if($redirect == 0){
				$_POST["type"]="customer";
				$_POST["id"]=$row[0];
				$cust_cookie_n = "id";
				$cust_cookie_v = $row[0];
				setcookie($cust_cookie_n, $cust_cookie_v, time() + (86400 * 30), '/');
				header('Location: ../templates/customer.php');
				die();
			} else if ($redirect == 1){
				$_POST["type"]="airline_employee";
				$_POST["id"]=$row[0];
				$_POST["emp_airline"]=$row[1];
				$ae_cookie_an = "aid";
				$ae_cookie_av = $row[1];
				setcookie($ae_cookie_n, $ae_cookie_v, time() + (86400 * 30), '/');
				$ae_cookie_en = "eid";
				$ae_cookie_ev = $row[0];
				setcookie($ae_cookie_en, $ae_cookie_ev, time() + (86400 * 30), '/');
				header('Location: ../templates/airlineemployee.php');
				die();
			} else if ($redirect == 2){
				$_POST["type"]="airline";
				$_POST["id"]=$row[0];
				$a_cookie_n = "id";
				$a_cookie_v = $row[0];
				setcookie($a_cookie_n, $a_cookie_v, time() + (86400 * 30), '/');
				header('Location: ../templates/airline.php');
				die();
			}
		} while(($row = oci_fetch_row($result)) != false);
	}
}

 ?>
 </body>
 </html>