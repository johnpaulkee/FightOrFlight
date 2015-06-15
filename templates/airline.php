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
      <li><a href="#" id="add_ticket">  Add Tickets so that customers can purchase them </a> </li>
      <li><a href="#" id="distribute_boarding_pass">  Distribute boarding passes </a> </li>
      <li><a href="#" id="myLink">  Check up details on their Airline Employees </a> </li>
      <li><a href="#" id="myLink">  Assign discounts for each airline employee </a> </li>
      <li><a href="#" id="myLink">  Update Customer’s Frequent Flyer Points </a> </li>
      <li><a href="#" id="myLink"> Join an Alliance </a> </li>
      <li><a href="#" id="myLink"> Choose the country that they want their headquarters in </a> </li>
      <li><a href="#" id="myLink"> Lookup Airport Details </a> </li>
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
          $("#form_generation").empty();
          $("#form_generation").load("tester.php", function(){
            $("#form_generation").fadeIn('slow');
          });
      });

 });
  </script>
  </html>
