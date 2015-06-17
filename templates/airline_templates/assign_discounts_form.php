<?php
    $type = $_COOKIE['type'];
      if ($type != "airline") {
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
      } else {}
      return $statement;
    }
?>

<form name = "discount_form" method = "post" action="airline_templates/assignDiscounts.php" id="disc_form">
  <label> Select Airline </label>
  <br>
  <?php 
  $query = "SELECT employeeID, employee_name FROM Airline_Employee_Employed_With";
    $result = executePlainSQL($query);
    // echo $result;
    while(($row = oci_fetch_row($result)) != false) {
      $option = '<input type="radio" name="employeeid" value="'.$row[0].'">'.$row[1].'</option> <br>';
      echo $option;
    }
    oci_free_statement($statement);
    oci_close($con);
    ?>
    <br>
  <label>Set Discount </label>
  <p>%<input type="text" name="discountvalue"></p>
  <input type="submit" value="Submit">
</form>


<script>
  $("#disc_form").submit(function() {
    var url = $(this).attr("action"); // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#hq_form").serialize(), // serializes the form's elements.
           success: function(data)
           {  
              alert("SUCCESS");
              $("#formresult").html(data); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
</script>