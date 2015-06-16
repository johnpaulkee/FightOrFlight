<p> Find airline headquarters </p>

<html>

<?php
include "head.php";
?>

<table class="table table-striped"> 
  <tablewidth="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>

    <form name="form1" method="post" action="customer_templates/check_headquarters.php" id="airline_head_form">
      <td>
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td>Please type in the Airline Name</td>
            <td>:</td>
            <td><input name="airlinename" type="text" id="airline"></td>
          </tr>
          <tr>
            <td><input type="submit" name="Submit" value="search"></td>
          </tr>
        </table>
      </td>
    </form>
  </tr>
</table>
<div class="container" id="formresult">
	
</div>

<script>
	
	$("#airline_head_form").submit(function() {

    var url = "/customer_templates/check_headquarters.php"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#idForm").serialize(), // serializes the form's elements.
           success: function(data)
           {
           		alert("SUCCESS");
              $("#form_result").load("customer_templates/check_headquarters.php"); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
</script>
</html>

