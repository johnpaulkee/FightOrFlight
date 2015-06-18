<form name="loyal_form" method="post" action="airline_templates/find_loyal_customers.php" id="loyal_form">
	<label> Find Most Loyal Customers Based On: </label><br>
	<input type="radio" name="method" value="revenue"> Revenue<br>
	<input type="radio" name="method" value="quantity"> Tickets Bought<br>
	<input type="submit" name="submit" value="OK">
</form>

<div id="formresult"></div>

<script>
	
	$("#loyal_form").submit(function() {

    var url = $(this).attr("action"); // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#loyal_form").serialize(), // serializes the form's elements.
           success: function(data)
           {	
           		alert("SUCCESS");
              $("#formresult").html(data); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
</script>

