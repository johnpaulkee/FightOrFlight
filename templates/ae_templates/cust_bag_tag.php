<p> Customer baggage details </p>
<?php
$type = $_COOKIE['type'];
    	if ($type != "airlineemployee") {
      		header("Location: ../templates/not_authorized.html");
      		die();
    	}
?>