<form name = "employee_member_form" method="post" action="airline_templates/employee_member.php" id="employee_member_form">
  <p> Select User </p>
  
    <?php
    require('../oci_query_header.php');

    $query = "SELECT ael.username, ael.employeeid 
              FROM Airline_Employee_Employed_With aeew, Airline_Employee_Login ael
              WHERE aeew.employeeid = ael.employeeid AND aeew.airline_code = ael.airline_code"; 

    $result = executePlainSQL($query);
    
    while(($row = oci_fetch_row($result)) != false) {
      $option = '<input type = "radio" name="employeeid" value="'.$row[1].'">'.$row[0].'</option>';
      echo $option;
      echo "<br>";
    }

    oci_free_statement($statement);
    oci_close($con);
    ?>

  <input type="submit" value="Submit">
</form>
<div id="formresult">

</div>

<script>
  $("#employee_member_form").submit(function() {

    var url = $(this).attr("action"); // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#employee_member_form").serialize(), // serializes the form's elements.
           success: function(data)
           {  
              alert("SUCCESS");
              $("#formresult").html(data); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
</script>