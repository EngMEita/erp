<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
require_once($rootPath."core/m/vacations.php");
$plan = getPlan();
if(canSeePage('ccp', $_SESSION['staff']['rolls'])){
	$typs = getVacations();
	$cuts = staffVacCut($plan['plan_id'], 0);
}elseif(canSeePage('hcp', $_SESSION['staff']['rolls'])){
	$typs = getVacations();
	$cuts = staffVacCut($plan['plan_id']);
}elseif(canSeePage('dcp', $_SESSION['staff']['rolls'])){
	$typs = getVacations(TRUE);
	$cuts = staffVacCut($plan['plan_id'], -1, $_SESSION['staff']['dept_id'], "d");
}elseif(canSeePage('scp', $_SESSION['staff']['rolls'])){
	$typs = getVacations(TRUE);
	$cuts = staffVacCut($plan['plan_id'], -2, $_SESSION['staff']['staff_id'], "s");
}else{
	include($rootPath."core/v/banned.php");
	die();
}
include($rootPath."core/v/header.php");
include($rootPath."core/v/hcp/vac/staffvacations.php");
include($rootPath."core/v/footer.php");
?>