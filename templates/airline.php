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
      <li><a href="#" id="add_ticket">Add Tickets</a> </li>
      <li><a href="#" id="distribute_boarding_pass">Distribute boarding passes </a> </li>
      <li><a href="#" id="check_details">View Airline Employee Details </a> </li>
      <li><a href="#" id="assign_discounts">Assign Airline Employee Discount</a> </li>
      <li><a href="#" id="update_freq_flyer">Update Customer Frequent Flyer Points</a> </li>
      <li><a href="#" id="join_alliance">Join an Alliance</a> </li>
      <li><a href="#" id="headquarter_in">Set Headquarters</a> </li>
      <li><a href="#" id="airport_details">View Airport Details </a> </li>
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
      <div class="panel-heading">Panel heading</div>
      <div class="panel-body" id="form_generation">
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
          Panel content
        </div>
      </div>
    </div>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/app.js"></script>
  </body>

  <script>

  $(document).ready(function(){

      $("#add_ticket").click(function() {
        $("#form_generation").load("tester.php").fadeIn('slow');
      });

      $("#distribute_boarding_pass").click(function() {
        $("#form_generation").load("tester.php").fadeIn('slow');
      });

      $("#check_details").click(function() {
        $("#form_generation").load("tester.php").fadeIn('slow');
      });

      $("#assign_discounts").click(function() {
        $("#form_generation").load("tester.php").fadeIn('slow');
      });

      $("#update_freq_flyer").click(function() {
        $("#form_generation").load("tester.php").fadeIn('slow');
      });

      $("#join_alliance").click(function() {
        $("#form_generation").load("tester.php").fadeIn('slow');
      });

      $("#headquarter_in").click(function() {
        $("#form_generation").load("tester.php").fadeIn('slow');
      });

      $("#airport_details").click(function() {
        $("#form_generation").load("tester.php").fadeIn('slow');
      });

 });
  </script>
  </html>
