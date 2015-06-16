<?php 
/* [EDIT by danbrown AT php DOT net: 
   The author of this note named this 
   file tmp.php in his/her tests. If 
   you save it as a different name, 
   simply update the links at the 
   bottom to reflect the change.] */ 

session_start(); 

$sessPath   = ini_get('session.save_path'); 
$sessCookie = ini_get('session.cookie_path'); 
$sessName   = ini_get('session.name'); 
$sessVar    = 'foo'; 

echo '<br>sessPath: ' . $sessPath; 
echo '<br>sessCookie: ' . $sessCookie; 

echo '<hr>'; 

if( !isset( $_GET['p'] ) ){ 
    // instantiate new session var 
    $_SESSION[$sessVar] = 'hello world'; 
}else{ 
    if( $_GET['p'] == 1 ){ 

        // printing session value and global cookie PHPSESSID 
        echo $sessVar . ': '; 
        if( isset( $_SESSION[$sessVar] ) ){ 
            echo $_SESSION[$sessVar]; 
        }else{ 
            echo '[not exists]'; 
        } 

        echo '<br>' . $sessName . ': '; 

        if( isset( $_COOKIE[$sessName] ) ){ 
        echo $_COOKIE[$sessName]; 
        }else{ 
            if( isset( $_REQUEST[$sessName] ) ){ 
            echo $_REQUEST[$sessName]; 
            }else{ 
                if( isset( $_SERVER['HTTP_COOKIE'] ) ){ 
                echo $_SERVER['HTTP_COOKIE']; 
                }else{ 
                echo 'problem, check your PHP settings'; 
                } 
            } 
        } 

    }else{ 

        // destroy session by unset() function 
        unset( $_SESSION[$sessVar] ); 

        // check if was destroyed 
        if( !isset( $_SESSION[$sessVar] ) ){ 
            echo '<br>'; 
            echo $sessName . ' was "unseted"'; 
        }else{ 
            echo '<br>'; 
            echo $sessName . ' was not "unseted"'; 
        } 

    } 
} 
?> 
<hr> 
<a href=tmp.php?p=1>test 1 (printing session value)</a> 
<br> 
<a href=tmp.php?p=2>test 2 (kill session)</a>

<html>

<?php
include "head.php";
?>

<table class="table table-striped"> 
  <tablewidth="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <form name="form1" method="post" action="check_login.php">
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
            <input type="radio" name="userType" value="customer">Customer
            <br>
            <input type="radio" name="userType" value="airlineemployee">Airline Employee
            <br>
            <input type="radio" name="userType" value="airline">Airline
            <br>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Login"></td>
          </tr>
        </table>
      </td>
    </form>
  </tr>
</table>
<?php
phpinfo();
?>
</html>
