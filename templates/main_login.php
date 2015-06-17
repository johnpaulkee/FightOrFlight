<html>

<?php include "head.php"; ?>

<div class = "jumbotron">
  <div class = "container">
    <table class="table table-striped"> 
      <tablewidth="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">

      <center>
      <form name="form1" method="post" action="check_login.php">
        <div class = "panel panel-default" style="width: 350px">
         <div class="panel-heading">Member Login</div>
         <div class="panel-body">
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">username</span>
          <input type="text" class="form-control" name="myusername" id="myusername" placeholder="demo" aria-describedby="basic-addon1">
        </div>

         <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">password </span>
          <input type="text" class="form-control" name="mypassword" id="mypassword" placeholder="123" aria-describedby="basic-addon1">
        </div>
        <br>
        <input type="submit" name="Submit" value="Login">
        </div>
        <div class="panel-footer">
         <input type="radio" name="userType" value="customer">Customer
        <input type="radio" name="userType" value="airlineemployee">Airline Employee
        <input type="radio" name="userType" value="airline">Airline
        </div>
      </form>
      </div>
    </tr>
  </table>
</div>
</div>

</html>
