<html>
<?php include 'head.php'; 
$type = $_COOKIE['type'];
      if ($type != "airline") {
          header("Location: ../templates/not_authorized.html");
          die();
      }
?>
<body>

  <div class="menu">

    <!-- Menu icon -->
    <div class="icon-close">
      <img src="http://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
    </div>

    <!-- Menu -->
    <ul>
      <li><a href="javascript:void(0)" id="add_ticket">Add Tickets</a> </li>
      <li><a href="javascript:void(0)" id="find_vip_customers">Find V.I.P Customers</a> </li>
      <li><a href="javascript:void(0)" id="check_details">View Airline Employee Details </a> </li>
      <li><a href="javascript:void(0)" id="assign_discounts">Assign Airline Employee Discount</a> </li>
      <li><a href="javascript:void(0)" id="headquarter_in">Set Headquarters</a> </li>
      <li><a href="javascript:void(0)" id="airport_details">View Airport Details </a> </li>
      <li><a href="javascript:void(0)" id="loyal_cust">Find Loyal Customers </a></li>
      <li><a href="javascript:void(0)" id="trash_plane">Retire Aircraft</a></li>
    </ul>
  </div>

  <!-- Main body -->
  <div class="jumbotron">

    <div class="icon-menu">
      <i class="fa fa-bars"></i>
      Menu
    </div>
    <div class="container">
      <div class="panel panel-default transparentbody">
      <div class="panel-heading">Welcome back
      <?php 
      echo $_COOKIE['username'];
      ?>
      </div>
      <div class="panel-body scroller" id="form_generation">
        <?php 
        function executePlainSQL($cmdstr) { 
      //echo "<br>running ".$cmdstr."<br>";
      $db_con = OCILogon("ora_i4u9a", "a34129122", "ug");
      $statement = OCIParse($db_con, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

      if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn); // For OCIParse errors pass the       
        // connection handle
        echo htmlentities($e['message']);
        $success = False;
      }

      $r = OCIExecute($statement, OCI_DEFAULT);
      if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
        echo htmlentities($e['message']);
        $success = False;
      } else {}
      return $statement;
    }
          $query = "SELECT airline_name FROM Airline_Headquartered_In WHERE airline_code =".$_COOKIE['id'];
          $result = executePlainSQL($query);
          $row = oci_fetch_row($result);
          echo "<p> Hello, ".$row[0]."</p>";
        ?>
      </div>
      </div>
    </div>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/app.js"></script>
  </body>

  <script>

  $(document).ready(function(){

      $("#add_ticket").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_add_ticket.php");
      });

      $("#find_vip_customers").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/find_vip_customers_form.php");
      });

      $("#check_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/employee_member_form.php");
      });

      $("#assign_discounts").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/assign_discounts_form.php");
      });

      $("#update_freq_flyer").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/headquarter_in_form.php");
      });

      $("#join_alliance").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/headquarter_in_form.php");
      });

      $("#headquarter_in").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/headquarter_in_form.php");
      });

      $("#airport_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/airport_details_form.php");
      });

      $("#loyal_cust").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/most_loyal_customers.php");
      });

      $("#trash_plane").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/retire_aircraft_form.php");
      });
 });
  </script>
  </html>
