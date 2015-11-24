<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/rolls.php");
if(canSeePage('acp', $_SESSION['staff']['rolls'])){
	if(isset($_POST['act'], $_POST['staff_id']) && $_POST['act'] == "addRolls" && intval($_POST['staff_id']) > 0){
		if(addRolls(intval($_POST['staff_id']), $_POST['rolls'])) $ntf = "تم تحديد الصلاحيات بنجاح";
	}
	$staff = getStaff(intval($_GET['staff_id']), 0, 1);
	include($rootPath."core/v/acp/staff/rolls.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>