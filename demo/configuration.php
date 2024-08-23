<?php
$host 		= "localhost"; // your hostname
$username	= "root"; // your host username
$password	= "london123"; // your host password
$db			= "asif18demo"; // Your database name
mysql_connect($host, $username, $password) or die("Oops! Coudn't connect to server"); // Connect to the server
mysql_select_db($db) or die("Oops! Coudn't select Database"); // Select the database
$now 	= mysql_fetch_array(mysql_query("SELECT NOW()"));
$now    = $now["NOW()"];
$unq	= date("his");
?>