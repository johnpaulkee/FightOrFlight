<?php session_start(); ?>

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
        <li><?php echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>"; ?></li>
        <li><a href="javascript:void(0)" id = "cust_info">My Account</a></li>
        <li><a href="javascript:void(0)" id = "purchase_ticket">Purchase Tickets</a></li>
        <li><a href="javascript:void(0)" id = "freq_flyer">Become a Frequent Flyer</a></li>
        <li><a href="javascript:void(0)" id = "check_points">Check Points</a></li>
        <li><a href="javascript:void(0)" id = "blacklist">Am I blacklisted?</a></li>	
        <li><a href="javascript:void(0)" id = "update_cred">Update Credit Card Info</a></li>
        <li><a href="javascript:void(0)" id = "lugg_weight">Check Luggage Weight</a></li>
        <li><a href="javascript:void(0)" id = "bp_details">Boarding Pass Details</a></li>
        <li><a href="javascript:void(0)" id = "find_airline_head">Find Airline Headquarters</a></li>
        <li><a href="javascript:void(0)" id = "plane_details">Plane Details</a></li>
        <li><a href="javascript:void(0)" id = "bagtag_details">Bag Tag Details</a></li>
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
      <div class="panel-heading"> Welcome back Customer         
        <?php
          echo $_POST["type"]." ".$_POST["id"];
          echo $_POST["type"];
          echo "you're a beauty";
          echo $GLOBALS["test"];
        ?>
      </div>
      <div class="panel-body scroller" id="form_generation">
          <?php
            include 'customer_templates/customer_data.php';
          ?>
        </div>
      </div>
    </div>

    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/app.js"></script>
  </body>

    <script>

  $(document).ready(function(){

      $("#cust_info").click(function() {
        $("#form_generation").load("../templates/customer_templates/customer_data.php").fadeIn('slow');
      });

      $("#purchase_ticket").click(function() {
        $("#form_generation").load("../templates/customer_templates/purchase_tickets.php").fadeIn('slow');
      });

      $("#freq_flyer").click(function() {
        $("#form_generation").load("../templates/customer_templates/frequent_flyer.php").fadeIn('slow');
      });

      $("#check_points").click(function() {
        $("#form_generation").load("../templates/customer_templates/check_points.php").fadeIn('slow');
      });

      $("#blacklist").click(function() {
        $("#form_generation").load("../templates/customer_templates/blacklisted.php").fadeIn('slow');
      });

      $("#update_cred").click(function() {
        $("#form_generation").load("../templates/customer_templates/cred_card.php").fadeIn('slow');
      });

      $("#lugg_weight").click(function() {
        $("#form_generation").load("../templates/customer_templates/lugg_weight.php").fadeIn('slow');
      });

      $("#bp_details").click(function() {
        $("#form_generation").load("../templates/customer_templates/board_pass.php").fadeIn('slow');
      });

      $("#find_airline_head").click(function() {
        $("#form_generation").load("../templates/customer_templates/airline_headquarters.php").fadeIn('slow');
      });

      $("#plane_details").click(function() {
        $("#form_generation").load("../templates/customer_templates/plane_details.php").fadeIn('slow');
      });

      $("#bagtag_details").click(function() {
        $("#form_generation").load("../templates/customer_templates/bag_tag_details.php").fadeIn('slow');
      });

 });
  </script>

</html>
