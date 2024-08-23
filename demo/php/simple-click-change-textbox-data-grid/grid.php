<?php
include '../../configuration.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simple onClick edit in jQuery Ajax PHP – Simple PHP Data Grid</title>
<meta name="keywords" content="onclick edit jquery php, grid in php, onclick change text box in jquery, onclick edit table row, insert update delete using jquery ajax, simple php data grid" />
<meta name="description" content="This article is about simple grid system using PHP, jQuery. Insert a new record to the table using by normal Ajax PHP. It will show the editable textbox when user clicks on the label." />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<link rel="shortcut icon" href="http://cdn.asif18.com//images/favicon.ico"/>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
$(function(){
	
	// Function for load the grid
	function LoadGrid() {
		var gridder = $('#as_gridder');
		var UrlToPass = 'action=load';
		gridder.html('loading..');
		$.ajax({
			url : 'ajax.php',
			type : 'POST',
			data : UrlToPass,
			success: function(responseText) {
				gridder.html(responseText);
			}
		});
	}
	
	// Seperate Function for datepiker() to save the value
	function ForDatePiker(ThisElement) {
		ThisElement.prev('span').html(ThisElement.val()).prop('title', ThisElement.val());
		var UrlToPass = 'action=update&value='+ThisElement.val()+'&crypto='+ThisElement.prop('name');
		$.ajax({
			url : 'ajax.php',
			type : 'POST',
			data : UrlToPass
		});
	}
	
	LoadGrid(); // Load the grid on page loads
	
	
	// Execute datepiker() for date fields
	$("body").delegate("input[type=text].datepicker", "focusin", function(){
		var ThisElement = $(this);
		$(this).datepicker({
	   		dateFormat: 'yy/mm/dd',
			onSelect: function() {
				setTimeout(ForDatePiker(ThisElement), 500);
			}
	   });
	});
	
	// Show the text box onClick
	$('body').delegate('.editable', 'click', function(){
		var ThisElement = $(this);
		ThisElement.find('span').hide();
		ThisElement.find('.gridder_input').show().focus();
	});
	
	// Pass and save the textbox values on blur function
	$('body').delegate('.gridder_input', 'blur', function(){
		var ThisElement = $(this);
		ThisElement.hide();
		ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
		var UrlToPass = 'action=update&value='+ThisElement.val()+'&crypto='+ThisElement.prop('name');
		if(ThisElement.hasClass('datepicker')) {
			return false;
		}
		$.ajax({
			url : 'ajax.php',
			type : 'POST',
			data : UrlToPass
		});
	});
	
	// Same as the above blur() when user hits the 'Enter' key
	$('body').delegate('.gridder_input', 'keypress', function(e){
		if(e.keyCode == '13') {
			var ThisElement = $(this);
			ThisElement.hide();
			ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
			var UrlToPass = 'action=update&value='+ThisElement.val()+'&crypto='+ThisElement.prop('name');
			if(ThisElement.hasClass('datepicker')) {
				return false;
			}
			$.ajax({
				url : 'ajax.php',
				type : 'POST',
				data : UrlToPass
			});
		}
	});
	
	// Function for delete the record
	$('body').delegate('.gridder_delete', 'click', function(){
		var conf = confirm('Are you sure want to delete this record?');
		if(!conf) {
			return false;
		}
		var ThisElement = $(this);
		var UrlToPass = 'action=delete&value='+ThisElement.attr('href');
		$.ajax({
			url : 'ajax.php',
			type : 'POST',
			data : UrlToPass,
			success: function() {
				LoadGrid();
			}
		});
		return false;
	});
	
	
	// Add new record
	
	// Add new record when the table is empty
	$('body').delegate('.gridder_insert', 'click', function(){
		$('#norecords').hide();
		$('#addnew').slideDown();
		return false;
	});
	
	
	// Add new record when the table in non-empty
	$('body').delegate('.gridder_addnew', 'click', function(){
		$('html, body').animate({ scrollTop: $('.as_gridder').offset().top}, 250); // Scroll to top gridder table
		$('#addnew').slideDown();
		return false;
	});
	
	// Cancel the insertion
	$('body').delegate('.gridder_cancel', 'click', function(){
		LoadGrid()
		return false;
	});
	
	// For datepiker
	$("body").delegate(".gridder_add.datepiker", "focusin", function(){
		var ThisElement = $(this);
		$(this).datepicker({
	   		dateFormat: 'yy/mm/dd'
	   });
	});
	
	// Pass the values to ajax page to add the values
	$('body').delegate('#gridder_addrecord', 'click', function(){
		
		// Do insert vaidation here
		if($('#fname').val() == '') {
			$('#fname').focus();
			alert('Enter the First Name');
			return false;
		}
		if($('#lname').val() == '') {
			$('#lname').focus();
			alert('Enter the Last Name');
			return false;
		}
		if($('#age').val() == '') {
			$('#age').focus();
			alert('Enter the Age');
			return false;
		}
		if($('#profession').val() == '') {
			$('#profession').focus();
			alert('Select the Profession');
			return false;
		}
		if($('#date').val() == '') {
			$('#date').focus();
			alert('Select the Date');
			return false;
		}
		
		// Pass the form data to the ajax page
		var data = $('#gridder_addform').serialize();
		$.ajax({
			url : 'ajax.php',
			type : 'POST',
			data : data,
			success: function() {
				LoadGrid();
			}
		});
		return false;
	});
	
});
</script>
</head>

<body>
<div class="as_wrapper">
	<center>
    <!-- demo_grid_bottom -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-0883938260025853"
         data-ad-slot="9825449644"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    </center>
    <br/>
	<h1 class="h1"><a href="http://asif18.com/21/php/simple-on-click-edit-in-jquery-ajax-php-simple-php-data-grid/">Simple onClick edit in jQuery Ajax PHP – Simple PHP Data Grid</a></h1>
	<div class="as_grid_container">
    	<p>NOTE: Table content will automatically get updated everyhour due to demo.</p>
        <div class="as_gridder" id="as_gridder"></div> <!-- GRID LOADER -->
    </div>
    <br/>
    <div class="bottom_add_container">
        <div class="demo_grid_bottom_left" style="float:left;">
            <!-- demo_grid_bottom_left -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:336px;height:280px"
                 data-ad-client="ca-pub-0883938260025853"
                 data-ad-slot="5116048442"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div class="demo_grid_botton_right" style="float:right;">
            <!-- demo_grid_botton_right -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:336px;height:280px"
                 data-ad-client="ca-pub-0883938260025853"
                 data-ad-slot="6592781640"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>
<?php include '../../../scripts_bottom_demo.php'; ?>
</body>
</html>