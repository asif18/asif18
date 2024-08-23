<?php
include '../../configuration.php';
include 'functions/functions.php';
$action = $_REQUEST['action'];

switch($action) {

	case "load":
		$query 	= mysql_query("SELECT * FROM `grid` ORDER BY id ASC");
		$count  = mysql_num_rows($query);
		if($count > 0) {
			while($fetch = mysql_fetch_array($query)) {
				$record[] = $fetch;
			}
		}
		$department = array('Software Architect', 'Inventor', 'Programmer', 'Entrepreneur');
		?>
        <table class="as_gridder_table">
            <tr class="grid_header">
                <td><div class="grid_heading">Sno</div></td>
                <td><div class="grid_heading">First Name</div></td>
                <td><div class="grid_heading">Last Name</div></td>
                <td><div class="grid_heading">Age</div></td>
                <td><div class="grid_heading">Profession</div></td>
                <td><div class="grid_heading">Date</div></td>
                <td><div class="grid_heading">Actions</div></td>
            </tr>
            <tr id="addnew">
            	<td>&nbsp;</td>
            	<td colspan="6">
                <form id="gridder_addform" method="post">
                <input type="hidden" name="action" value="addnew" />
                <table width="100%">
                <tr>
                    <td><input type="text" name="fname" id="fname" class="gridder_add" /></td>
                    <td><input type="text" name="lname" id="lname" class="gridder_add" /></td>
                    <td><input type="text" name="age" id="age" class="gridder_add" /></td>
                    <td><select name="profession" id="profession" class="gridder_add select">
                        <option value="">SELECT</option>
                        <?php foreach($department as $departments) { ?>
                        <option value="<?php echo $departments; ?>"><?php echo $departments; ?></option>
                        <?php } ?>
                        </select></td>
                    <td><input type="text" name="date" id="date" class="gridder_add datepiker" /></td>
                    <td>&nbsp;
                    <input type="submit" id="gridder_addrecord" value="" class="gridder_addrecord_button" title="Add" />
                    <a href="cancel" id="gridder_cancel" class="gridder_cancel"><img src="images/delete.png" alt="Cancel" title="Cancel" /></a></td>
				</tr>
                </table>                    
                </form>
            </tr>
            <?php
            if($count <= 0) {
            ?>
            <tr id="norecords">
                <td colspan="7" align="center">No records found <a href="addnew" id="gridder_insert" class="gridder_insert"><img src="images/insert.png" alt="Add New" title="Add New" /></a></td>
            </tr>
            <?php } else {
            $i = 0;
            foreach($record as $records) {
            $i = $i + 1;
            ?>
            <tr class="<?php if($i%2 == 0) { echo 'even'; } else { echo 'odd'; } ?>">
                <td><div class="grid_content sno"><span><?php echo $i; ?></span></div></td>
                <td><div class="grid_content editable"><span><?php echo $records['fname']; ?></span><input type="text" class="gridder_input" name="<?php echo encrypt("fname|".$records['id']); ?>" value="<?php echo $records['fname']; ?>" /></div></td>
                <td><div class="grid_content editable"><span><?php echo $records['lname']; ?></span><input type="text" class="gridder_input" name="<?php echo encrypt("lname|".$records['id']); ?>" value="<?php echo $records['lname']; ?>" /></div></td>
                <td><div class="grid_content editable"><span><?php echo $records['age']; ?></span><input type="text" class="gridder_input" name="<?php echo encrypt("age|".$records['id']); ?>" value="<?php echo $records['age']; ?>" /></div></td>
                <td><div class="grid_content editable"><span><?php echo $records['profession']; ?></span>
                <select class="gridder_input select" name="<?php echo encrypt("profession|".$records['id']); ?>">
                    <?php foreach($department as $departments) { ?>
                    <option value="<?php echo $departments; ?>" <?php if($departments == $records['profession']) { echo 'selected="selected"'; } ?>><?php echo $departments; ?></option>
                    <?php } ?>
                </select>
                </div></td>
                <td><div class="grid_content editable"><span><?php echo date("Y/m/d", strtotime($records['posted_date'])); ?></span><input type="text" class="gridder_input datepicker" name="<?php echo encrypt("posted_date|".$records['id']); ?>" value="<?php echo date("Y/m/d", strtotime($records['posted_date'])); ?>" /></div></td>
                <td>
                <a href="gridder_addnew" id="gridder_addnew" class="gridder_addnew"><img src="images/insert.png" alt="Add New" title="Add New" /></a>
                <a href="<?php echo encrypt($records['id']); ?>" class="gridder_delete"><img src="images/delete.png" alt="Delete" title="Delete" /></a></td>
            </tr>
            <?php
                }
            }
            ?>
            </table>
        <?php
	break;
	
	case "addnew":
		$fname 		= isset($_POST['fname']) ? mysql_real_escape_string($_POST['fname']) : '';
		$lname 		= isset($_POST['lname']) ? mysql_real_escape_string($_POST['lname']) : '';
		$age 		= isset($_POST['age']) ? mysql_real_escape_string($_POST['age']) : '';
		$profession = isset($_POST['profession']) ? mysql_real_escape_string($_POST['profession']) : '';
		$date 		= isset($_POST['date']) ? mysql_real_escape_string($_POST['date']) : '';
		mysql_query("INSERT INTO `grid` (fname, lname, age, profession, posted_date) VALUES ('$fname', '$lname', '$age', '$profession', '$date')");
	break;
	
	
	case "update":
		$value 	= $_POST['value'];
		$crypto = decrypt($_POST['crypto']);
		$explode = explode('|', $crypto);
		$columnName = $explode[0];
		$rowId = $explode[1];
		if($columnName == 'posted_date') { // Check the column is 'date', if yes convert it to date format
			$datevalue = $value;
			$value 	   = date('Y-m-d', strtotime($datevalue));
		}
		$query = mysql_query("UPDATE `grid` SET `$columnName` = '$value' WHERE id = '$rowId' ");
	break;
	
	case "delete":
		$value 	= decrypt($_POST['value']);
		$query = mysql_query("DELETE FROM `grid` WHERE id = '$value' ");
	break;
}
?>