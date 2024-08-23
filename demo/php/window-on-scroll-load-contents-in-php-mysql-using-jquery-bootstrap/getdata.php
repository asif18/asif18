<?php
include 'library.php'; // include the library file
session_start();
if(isset($_POST["lastid"]) && $_POST["lastid"] != "0"){
	$lastid = $_POST["lastid"]; // save the posted value in a variable
	if($_SESSION['lastid'] != $_POST["lastid"]) { // Check session for avoid duplicate records
		$country_select = mysql_query("SELECT * FROM `countries` WHERE country_id < '$lastid' ORDER BY country_id DESC LIMIT 5");
		if(mysql_num_rows($country_select) > 0){
			$last_id = '';
			while($fetch = mysql_fetch_array($country_select)){
			?>
			<div class="as_country_container" id="<?php echo $fetch["country_id"]; ?>">
				<table>
				<tr>
					<td style="width:300px;"><?php echo $fetch["country_name"]; ?></td>
					<td><img src="country_flags/<?php echo $fetch["country_code"]; ?>.png" alt="<?php echo $fetch["country_code"]; ?>" title="<?php echo $fetch["country_code"]; ?>" /></td>
				</tr>
				</table>
			</div>
		<?php
			$last_id = $fetch["country_id"];
			}
			$_SESSION['lastid'] = $lastid; // Create session for check and avoid dupilicate records
		}
	}
}
?>