<p> Find airline headquarters </p>

<html>

<?php
include "head.php";
?>

<table class="table table-striped"> 
  <tablewidth="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <form name="form1" method="post" action="customer_templates/check_headquarters.php">
      <td>
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td>Please type in the Airline Name</td>
            <td>:</td>
            <td><input name="airlinename" type="text" id="airline"></td>
          </tr>
          <tr>
            <td><input type="submit" name="Submit" value="Login"></td>
          </tr>
        </table>
      </td>
    </form>
  </tr>
</table>
</html>

