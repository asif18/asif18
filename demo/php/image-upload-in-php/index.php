<?php
/*
CREATE TABLE `demo`.`upload` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`file_name` VARCHAR( 300 ) NOT NULL ,
`post_date` DATETIME NOT NULL 
) ENGINE = InnoDB;
*/
include "../../configuration.php";
if(isset($_POST["post_file"])){
	if($_POST["post_file"] != ""){
		$valid_files = array("png", "jpg", "gif"); // include the valid image file extensions
		$file_name	 = $_FILES["your_file"]["name"]; // get the image name you posting
		$file_name_exp = explode(".", $file_name); // explode the uploaded image to get extension
		$file_extension = $file_name_exp[1]; // get extension
		if(in_array($file_extension, $valid_files)){ // check that image is valid or not
			$change_file_name = strtolower(str_replace(" ", "_", $file_name_exp[0])); // change the image name
			$file_name		  = $change_file_name.".".$file_extension; // join the new image name and its extension
			$folder_name	  = "uploads/"; // get the directory name which you want to upload the image make sure this directory has 0755 permision
			$target			  = $folder_name.$file_name; 
			$temp_name		  = $_FILES["your_file"]["tmp_name"]; // get the temp name of the image
			$move			  = move_uploaded_file($temp_name, $target); // move_uploaded_file function will let us to copy the file from your local drive to your root directory
			if($move){
				mysql_query("INSERT INTO `upload` (file_name, post_date) VALUES ('$file_name', now())");
				echo "<script type=\"text/javascript\">window.location = 'index.php?result=success';</script>";	
			}else{
				echo "<script type=\"text/javascript\">window.location = 'index.php?result=error';</script>";	
			}
		}else{
			echo "<script type=\"text/javascript\">window.location = 'index.php?result=error';</script>";	
		}
	}else{
		echo "<script type=\"text/javascript\">window.location = 'index.php?result=error';</script>";	
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<title>Upload image in php by Asif18</title>
<style type="text/css">
body{
	font-family:Arial;
	color:#333333;
	font-size:14px;
}
.mytable{
	margin:0 auto;
	padding:10px;
	border:#007EB2 dashed 2px;
	font-weight:bold;
}
.mytable tr{
	line-height:70px;
}
.button{
	background:#007EB2;
	border:none;
	padding:8px 10px;
	text-align:center;
	color:#FFF;
	cursor:pointer;
	border=radius:2px;
}
h2, h3{
	margin:0;
	padding:0;
	text-align:center;
}
.error{
	color:#F33C21;
}
.success{
	color:#008040;
}
</style>
</head>

<body>
<h2>Image Upload in php</h2>
<?php if(isset($_GET["result"]) && $_GET["result"] == "error"){ echo "<h3 class=\"error\">Oops! something went wrong. Please upload again</h3>"; } ?>
<?php if(isset($_GET["result"]) && $_GET["result"] == "success"){ echo "<h3 class=\"success\">Yay yay!! Image uploaded successfully</h3>"; } ?>
<br/>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<table class="mytable">
<tr>
	<td><label>Select an image : </label></td>
	<td><input type="file" name="your_file" /></td>
</tr>
<tr>
	<td colspan="2"  align="center"><input type="submit" name="post_file" class="button" value="Upload This Image" /></td>
</tr>
<tr>
	<td colspan="2"  align="center"><input type="button" onClick="window.location='?view_images';" name="view_images" class="button" value="View Images" /></td>
</tr>
</table>
</form>
<?php
if(isset($_GET["view_images"])){
?>
<br/>
<h3>Hard refresh if you cant see the uploaded image</h3>
<table class="mytable">
<tr>
	<td><label>Sno</label></td>
    <td><label>Image Name</label></td>
    <td><label>Image</label></td>
</tr>
<?php
	$select		= mysql_query("SELECT * FROM `upload` ORDER BY id DESC LIMIT 10");
	$i = 0;
	while($fetch = mysql_fetch_array($select)){
	$i = $i + 1;
?>
<tr>
	<td><label><?php echo $i; ?></label></td>
    <td><label><?php echo $fetch["file_name"]; ?></label></td>
    <td><label><img src="uploads/<?php echo $fetch["file_name"]; ?>" alt="<?php echo $fetch["file_name"]; ?>" title="<?php echo $fetch["file_name"]; ?>" height="50" width="50" /></label></td>
</tr>
<?php 
	}
?>
</table>
<?php
}
?>
</body>
</html>