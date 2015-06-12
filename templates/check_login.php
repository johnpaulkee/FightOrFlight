<html>
 <head></head>
  <body>
  <?php
   
  // variables
  //ob_start();
  $succes = true;
  $dbconn = OCILogon("ora_i4u9a", "a34129122", "ug");
  $table_name = "users";
 // Define user and pass
 $username = $_POST['myusername'];
 $password = $_POST['mypassword'];
 
 echo $username;
 echo $password;
 
 //$query = "SELECT * FROM $table_name WHERE username='$myusername' AND password='$mypas    sword'";
 //$statement = OCIParse($dbconn, $query);
 //$r = OCIExecute($statement, OCI_DEFAULT);
 //$count = oci_num_rows($statement);
 //if ($count == 1)) {
 //      session_register("myusername");
 //      session_register("mypassword");
         header("location:../index.php");
 //}
 //else {
 //      echo "Wrong username or password. Please try again. Or fuck off";
 //}
 //ob_end_flush();
 ?>
 </body>
 </html>