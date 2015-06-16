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
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/app.js"></script>
  <script>

  $(document).ready(function(){

      $("#sell_ticket").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#customer_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#airline_aircraft_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#aircraft_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#baggage_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#discount_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#purchase_discounted_ticket").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#purchased_ticket_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#airline_aircraft_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });
      
      $("#headquarter_location").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });

      $("#boarding_pass_details").click(function() {
        $("#form_generation").empty();
        $("#form_generation").load("tester.php");
      });
 });
  </script>
  </body>
</html>
