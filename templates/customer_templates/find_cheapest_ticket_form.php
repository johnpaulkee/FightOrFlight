<form name="cheap_form" method="post" action="../templates/customer_templates/find_cheapest_ticket.php" id="cheapest_form">
	<label>Where are you?</label>
	<?php
	$type = $_COOKIE['type'];
    if ($type != "customer") {
      header("Location: ../templates/not_authorized.html");
      die();
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

 	   	$query="SELECT DISTINCT city FROM Airport_LocatedIn";
  		$result = executePlainSQL($query);
  		// echo($result);
  		while(($row = oci_fetch_row($result)) != false) {
        echo '<br>';
  			$input = '<input type="radio" name="city" value="'.$row[0].'">'.$row[0];
  			echo $input;
  		}
	?>
  <br>
	<button type="submit" name="submit"  class="btn btn-default"> Select </button>
</form>

<div id="formresult"></div>

<script>
	
	$("#cheapest_form").submit(function() {

    var url = $(this).attr("action"); // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#cheapest_form").serialize(), // serializes the form's elements.
           success: function(data)
           {	
              $("#formresult").html(data); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
</script>