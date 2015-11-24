<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/depts.php");
if(canSeePage('dcp', $_SESSION['staff']['rolls'])){
	
	$ss = deptStaff($_SESSION['staff']['dept_id']);
	$staff = array();
	foreach($ss as $s){
		$x = getStaff($s['staff_id']);
		$staff[] = $x[0];
	}
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/dcp/staff.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>