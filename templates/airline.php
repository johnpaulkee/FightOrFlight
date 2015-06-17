<html>
<?php include 'head.php'; ?>
<body>

  <div class="menu">

    <!-- Menu icon -->
    <div class="icon-close">
      <img src="http://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
    </div>

    <!-- Menu -->
    <ul>
      <li><a href="javascript:void(0)" id="add_ticket">Add Tickets</a> </li>
      <li><a href="javascript:void(0)" id="distribute_boarding_pass">Distribute boarding passes </a> </li>
      <li><a href="javascript:void(0)" id="check_details">View Airline Employee Details </a> </li>
      <li><a href="javascript:void(0)" id="assign_discounts">Assign Airline Employee Discount</a> </li>
      <li><a href="javascript:void(0)" id="update_freq_flyer">Update Customer Frequent Flyer Points</a> </li>
      <li><a href="javascript:void(0)" id="join_alliance">Join an Alliance</a> </li>
      <li><a href="javascript:void(0)" id="headquarter_in">Set Headquarters</a> </li>
      <li><a href="javascript:void(0)" id="airport_details">View Airport Details </a> </li>
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
        <p> TODO: include airline details </p>
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

      $("#distribute_boarding_pass").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#check_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#assign_discounts").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#update_freq_flyer").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#join_alliance").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#headquarter_in").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/headquarter_in.php");
      });

      $("#airport_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("airline_templates/airport_details.php");
      });

 });
  </script>
  </html>
