<html>

  <head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </head>

  <body>
    <?php include "navbar.php" ;?>
          <!-- Menu icon -->
      <div class="icon-close">
        <img src="http://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
      </div>

      <!-- Menu -->
  <div class="menu">
        <ul>
          <li><a href="#">Sell Ticket</a></li>
           <li><a href="#">Customer Details</a></li>
           <li><a href="#">Airline Details</a></li>
           <li><a href="#">Aircraft Details</a></li>    
           <li><a href="#">Customer Baggage Details</a></li>    
           <li><a href="#">Discount Details</a></li>    
           <li><a href="#">Purchase Discounted Ticket</a></li>  
           <li><a href="#">Purchased Ticket Details</a></li>    
           <li><a href="#">Able to all the Planes owned by an Airline</a></li>    
           <li><a href="#">Airline Headquarter Location</a></li>    
           <li><a href="#">Lookup Boarding Pass Details</a></li>    
       </ul>
        <ul>
          <li><a href="#">Purchase Ticket</a></li>
           <li><a href="#">Become a Frequent Flyer</a></li>
           <li><a href="#">Check Points</a></li>
           <li><a href="#">Purchased Tickets Details</a></li>   
           <li><a href="#">Are you blacklisted?</a></li>    
           <li><a href="#">Purchased Tickets Details</a></li>   
           <li><a href="#">Update your Credit Card Information</a></li> 
           <li><a href="#">Check Luggage Weight</a></li>    
           <li><a href="#">Lookup Boarding Pass Details</a></li>    
           <li><a href="#">Check Airline Headquarters</a></li>    
           <li><a href="#">Check Plane Details</a></li>   
           <li><a href="#">Purchased Tickets Details </a></li>    
       </ul>
      </div>

        <form class="navbar-form navbar-left" role="search">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#">Link</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <?php include 'oracle-test.php'; ?>

  </body>

</html>
