<?php
/**
Simple bootstrap using php mysql jquery by asif18.com, for more tutorials visit: http://www.asif18.com
for this tutorial visit: http://www.asif18.com/4/php/window-on-scroll-load-contents-in-php-mysql-using-jquery-bootstrap/
**/
include 'library.php'; // include the database and server connection file
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Simple jQuery PHP MySql bootsrap module by Asif18</title>
<meta name="keywords" content="boostrap in jquey, on scroll load data in php mysql, simple jQuery bootstrap"/>
<meta name="description" content="window on scroll load contents using php, mysql, jquery a simple bootsrap module in jQuery"/>
<script type="text/javascript" src="jquery-1.9.1.js"></script>
<style>
.as_wrapper{
	margin:0 auto;
	width:500px;
	font-family:Arial;
	color:#333;
	font-size:14px;
}
.as_country_container{
	padding:20px;
	border:2px dashed #17A3F7;
	margin-bottom:10px;
}
.add_left {
	display:none;
	position:fixed;
	left:0;
	height:600px;
	width:300px;
	margin-left:10px;
}
.add_right {
	display:none;
	position:fixed;
	right:0;
	height:600px;
	width:300px;
	margin-right:10px;
}
@media screen and (min-width: 1280px) {
	.add_left, .add_right {
		display:block;
	}
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$(window).scroll(function(){ /* window on scroll run the function using jquery and ajax */
		var WindowHeight = $(window).height(); /* get the window height */
		if($(window).scrollTop() +1 >= $(document).height() - WindowHeight){ /* check is that user scrolls down to the bottom of the page */
			$("#loader").html("<img src='loading_icon.gif' alt='loading'/>"); /* displa the loading content */
			var LastDiv = $(".as_country_container:last"); /* get the last div of the dynamic content using ":last" */
			var LastId  = $(".as_country_container:last").attr("id"); /* get the id of the last div */
			var ValueToPass = "lastid="+LastId; /* create a variable that containing the url parameters which want to post to getdata.php file */
			$.ajax({ /* post the values using AJAX */
			type: "POST",
			url: "getdata.php",
			data: ValueToPass,
			cache: false,
				success: function(html){
					$("#loader").html("");
					LastDiv.after(html); /* get the out put of the getdata.php file and append it after the last div using after(), for each scroll this function will execute and display the results */
				}
			});
		}
	});
});
</script>
</head>

<body>
<div class="add_left">
<!-- demo_bootstrap_left -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:600px"
     data-ad-client="ca-pub-0883938260025853"
     data-ad-slot="7147430045"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<div class="add_right">
<!-- demo_bootstrap_right_sky -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:600px"
     data-ad-client="ca-pub-0883938260025853"
     data-ad-slot="2438028843"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
<div class="as_wrapper">
	<h1>Window on scroll load contents in php mysql jquery using simple jQuery bootstrap module</h1>
	<?php
	$country_select = mysql_query("SELECT * FROM `countries` ORDER BY country_id DESC LIMIT 10");
	while($fetch = mysql_fetch_array($country_select)){
	?>
	<div class="as_country_container" id="<?php echo $fetch["country_id"]; ?>"> <!-- set the mysql row id or primary key value as div id here -->
    	<table>
        <tr>
        	<td style="width:300px;"><?php echo $fetch["country_name"]; ?></td>
            <td><img src="country_flags/<?php echo $fetch["country_code"]; ?>.png" alt="<?php echo $fetch["country_code"]; ?>" title="<?php echo $fetch["country_code"]; ?>" /></td>
        </tr>
        </table>
    </div>
    <?php 
	}
	?>
    <div id="loader"></div>
    <div id="divResult"></div> <!-- here the rest of contents will display dynamically -->
</div>
<?php include '../../../scripts_bottom_demo.php'; ?>
</body>
</html>