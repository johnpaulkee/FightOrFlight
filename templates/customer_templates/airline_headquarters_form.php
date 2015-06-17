<p> TODO: Find airline headquarters </p>

<html>

<?php
include "head.php";
$type = $_COOKIE['type'];
    if ($type != "customer") {
      header("Location: ../templates/not_authorized.html");
      die();
    }
?>

<table class="table table-striped"> 
  <tablewidth="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>

    <form name="form1" method="post" action="../templates/customer_templates/check_headquarters.php" id="airline_head_form">
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

    var url = $(this).attr("action"); // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#airline_head_form").serialize(), // serializes the form's elements.
           success: function(data)
           {	
           		alert("SUCCESS");
              $("#formresult").html(data); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
</script>
</html>

