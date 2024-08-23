<?php
session_start();
$msg = '';
if(isset($_POST["submit"])){
	$original_captcha = $_SESSION["captcha"]; // session 'captcha' has been alreadey created in captcha.php file, if you want to rename the session open the captcha.php file and find and change the name of the session
	$user_captcha = $_POST["captcha"];
	if($user_captcha == $original_captcha){
		$msg = '<span class="success">Captcha Matched!</span>';
	}else{
		$msg = '<span class="error">Oops! Captcha Mismatched!</span>';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simple captcha validation with dynamic captcha refresh by asif18</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#change_captcha").click(function(){
		$("#as_captcha").attr("src", "captcha.php?"+(new Date()).getTime()); // browser will save the captcha image in its cache so add '?some_unique_char' to set new URL for each click
	});
});
</script>
<style>
body{
	margin: 0;
	padding: 0;
	font-family: arial;
	color: #2C2C2C;
	font-size: 14px;
}
h1 a{
	color:#2C2C2C;
	text-decoration:none;
}
h1 a:hover{
	text-decoration:underline;
}
a{
	color: #069FDF;
	cursor:pointer;
}
.wrapper{
	margin: 0 auto;
	width: 1000px;
}
.mytable{
	width: 700px;
	margin: 0 auto;
	border:2px dashed #17A3F7;
	padding: 20px;
}
.success{
	color:#009900;
	font-weight:bold;
}
.error{
	color:#F33C21;
	font-weight:bold;
}
</style>
</head>
<body>
<div class="wrapper">
<h1><a href="http://www.asif18.com/12/php/captcha-in-php-by-google-captcha-with-dynamic-reload/">Simple captcha with dynamic refresh</a></h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<table class="mytable">
<tr>
	<td colspan="2" align="center"><?php echo $msg; ?></td>
</tr>
<tr>
	<td valign="bottom">Enter the captcha:</td>
    <td><img src="captcha.php" id="as_captcha" alt="Captcha" /></td>
</tr>
<tr>
	<td><input type="text" name="captcha" /></td>
    <td><a class="a" id="change_captcha">Can't read? try another one</a></td>
</tr>
<tr>
	<td><input type="submit" name="submit" value="Post It" /></td>
</tr>
</table>
</form>
<!-- demo_captcha -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-0883938260025853"
     data-ad-slot="1020171248"></ins>
</div>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php include '../../../scripts_bottom_demo.php'; ?>
</body>
</html>