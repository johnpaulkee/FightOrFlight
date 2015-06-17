<form name="cheap_form" method="post" action="find_cheapest_ticket.php" id="cheapest_form">
	<label>Where are you?</label>
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
 	     } else {
  	    }
  	    return $statement;
 	   	}

 	  //  	$query="SELECT DISTINCT city FROM Airport_LocatedIn";
  		// $result = executePlainSQL($query);
  		// while(($row = oci_fetch_row($result)) != false) {
  		// 	$input = '<input type="radio" name="city" value="'.$row[0].'">'.$row[0].'<br>';
  		// 	echo $input;
  		// }
	?>
	<input type="submit" name="submit" value="ok">
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
           		alert("SUCCESS");
              $("#formresult").html(data); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
</script>