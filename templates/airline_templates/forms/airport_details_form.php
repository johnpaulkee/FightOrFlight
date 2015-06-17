<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_i4u9a", "a34129122", "ug");
?>

<form name="form2" method="post" action="../templates/airline_templates/phpscripts/getAirportDetails.php">
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
function printResult($result) { //prints results from a select statement
  echo "<h3><center> Here are the details for all the airports: </center></h3>";

  echo "<table class = 'table table-striped'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>Airport Code</th>";
  echo "<th>Number of Domestic Gates</th>";
  echo "<th>City</th>";
  echo "<th>Country</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  while (($row = oci_fetch_row($result)) != false) {
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "</td>";
    echo "<td>" . $row[3] . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
  echo $result;

}

// Connect Oracle...
if ($db_conn) {
  $query = "SELECT * from Airport_LocatedIn";
  $result = executePlainSQL($query);
  echo $result;
  //echo $airline;
  printResult($result);
}
?>
