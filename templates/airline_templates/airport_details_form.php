<?php
$type = $_COOKIE['type'];
      if ($type != "airline") {
          header("Location: ../templates/not_authorized.html");
          die();
      }
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");
?>

<form name="form2" method="post" action="../templates/airline_templates/getAirportDetails.php" id="details">
  <label> Select Airport Code </label>
  <select class="form-control" name="apt" >
    <?php
    require('../oci_query_header.php');

    $query = "SELECT airport_code 
          FROM Airport_LocatedIn";
    $result = executePlainSQL($query);
    echo $result;
    while(($row = oci_fetch_row($result)) != false) {
      $option = "<option value='".$row[0]."'>".$row[0]."</option>";
      echo $option;
    }
    oci_free_statement($statement);
    oci_close($con);
    ?>
  </select>
  <input type="submit" value="Submit">
</form>

<?php

// Connect Oracle...
if ($db_conn) {
  $query = "SELECT * from Airport_LocatedIn";
  $result = executePlainSQL($query);
  echo $result;
  //echo $airline;
}
?>

<div id="formresult"></div>

<script>

  
  $("#getAirportDetails").submit(function() {

    var url = $(this).attr("action");

    $.ajax({
           type: "POST",
           url: url,
           data: $("#details").serialize(),
           success: function(data)
           {  
              alert("SUCCESS");
              $("#formresult").html(data);
           }
         });

    return false;
});
</script>
