<form name="cheap_form" method="post" action="find_cheapest_ticket.php" id="cheapest_form">
	<label>Where are you?</label>
	
	<input type="submit" name="submit" value="ok">
</form>

<div id="formresult"></div>

<script>
	
	$("#cheapest_form").submit(function() {

    var url = $(this).attr("action"); // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#cheapest_form").serialize(), // serializes the form's elements.
           success: function(data)
           {	
           		alert("SUCCESS");
              $("#formresult").html(data); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
</script>