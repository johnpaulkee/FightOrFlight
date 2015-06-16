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
        <li><a href="javascript:void(0)" id="my_account">My Account</a></li>
        <li><a href="javascript:void(0)" id="sell_ticket">Sell Ticket</a></li>
        <li><a href="javascript:void(0)" id="customer_details">Customer Details</a></li>
        <li><a href="javascript:void(0)" id="airline_details">Airline Details</a></li>
        <li><a href="javascript:void(0)" id="aircraft_details">Aircraft Details</a></li>    
        <li><a href="javascript:void(0)" id="baggage_details">Customer Baggage Details</a></li>    
        <li><a href="javascript:void(0)" id="discount_details">Discount Details</a></li>    
        <li><a href="javascript:void(0)" id="purchase_discounted_ticket">Purchase Discounted Ticket</a></li>  
        <li><a href="javascript:void(0)" id="purchased_ticket_details">Purchased Ticket Details</a></li>    
        <li><a href="javascript:void(0)" id="airline_aircraft_details">Airline Aircraft Details</a></li>    
        <li><a href="javascript:void(0)" id="headquarter_location">Airline Headquarter Location</a></li>    
        <li><a href="javascript:void(0)" id="boarding_pass_details">Boarding Pass Details</a></li> 
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
      <div class="panel-heading"> Welcome back Customer</div>
      <div class="panel-body scroller" id="form_generation">
          <?php
            include 'ae_templates/airline_employee_data.php';
          ?>
        </div>
      </div>
    </div>

    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/app.js"></script>
  </body>

    <script>

  $(document).ready(function(){

      $("#my_account").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/airline_employee_data.php");
      });

      $("#sell_ticket").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/sell_ticket.php");
      });

      $("#customer_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/cust_details.php");
      });

      $("#airline_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/airline_details.php");
      });

      $("#aircraft_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/airline_aircraft_details.php");
      });

      $("#baggage_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/cust_bag_tag.php");
      });

      $("#discount_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/discount_details.php");
      });

      $("#purchase_discounted_ticket").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/purchase_discount_ticket.php");
      });

      $("#purchased_ticket_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/purchased_ticket_details.php");
      });

      $("#airline_aircraft_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/airline_aircraft_details.php");
      });
      
      $("#headquarter_location").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/airline_head_loc.php");
      });

      $("#boarding_pass_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("../templates/ae_templates/board_pass_details.php");
      });
 });
  </script>

</html>
