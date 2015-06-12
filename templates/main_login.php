<html>

<?php
include "head.php";
?>

<table class="table table-striped"> 
  <tablewidth="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <form name="form1" method="post" action="checklogin.php">
      <td>
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
          <tr>
            <td colspan="3"><strong>Member Login </strong></td>
          </tr>
          <tr>
            <td width="78">Username</td>
            <td width="6">:</td>
            <td width="294"><input name="myusername" type="text" id="myusername"></td>
          </tr>
          <tr>
            <td>Password</td>
            <td>:</td>
            <td><input name="mypassword" type="text" id="mypassword"></td>
          </tr>
          <tr>
            <select name="userType">
              <option value="A">Airline</option>
              <option value="C">Customer</option>
              <option value="E">Employee</option>
            </select>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Login"></td>
          </tr>
        </table>
      </td>
    </form>
  </tr>
</table>
</html>
