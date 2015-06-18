<form name = "form2" method = "post" action="../templates/airline_templates/addHq.php" id="hq_form">
  <label> Select Airline </label>
  <select class="form-control" name="aln">
    <?php
    require('../oci_query_header.php');
    $type = $_COOKIE['type'];
      if ($type != "airline") {
          header("Location: ../templates/not_authorized.html");
          die();
      }

    $query = "SELECT airline_code, airline_name, name 
          FROM Airline_Headquartered_In";
    $result = executePlainSQL($query);
    echo $result;
    while(($row = oci_fetch_row($result)) != false) {
      $option = '<option name="ahq" value="'.$row[0].'">'.$row[0].", ".$row[1].", ".$row[2].'</option>';
      echo $option;
    }
    oci_free_statement($statement);
    oci_close($con);
    ?>
  </select>
  <label>Set HeadQuarters to: </label>
  <p>$<input type="text" name="hq" maxlength="255"></p>
  <input type="submit" value="Submit">
</form>

<div id="formresult">
  
</div>

<script>
  $("#hq_form").submit(function() {

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