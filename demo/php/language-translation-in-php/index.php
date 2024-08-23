<?php
/******
Language translation in PHP
Author : asif18
for more tutorials visit asif18.com
*****/
include 'library.php'; // include the library to get the session values
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang["login"]; // echo the array texts which you saved in language files ?></title>
</head>

<body>
<select onChange="window.location = '?lang='+this.value+''">
<option value="" selected="selected" disabled="disabled">Select language</option>
<option value="en">English</option>
<option value="ar">Arabic</option>
<option value="es">Spanish</option>
</select>
<h1><?php echo $lang["welcome"]; // echo the array texts which you saved in language files ?></h1>
<p><?php echo $lang["this page's language will be dynamically changed. open the library file and change the session value to see the language translation"]; // echo the array texts which you saved in language files ?></p>
</body>
</html>
