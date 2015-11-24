<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
require_once($rootPath."core/m/vacations.php");
if(canSeePage('hcp', $_SESSION['staff']['rolls'])){
	//$plan  = getPlan();
	$date = isset($_GET['d']) ? $_GET['d'] : $tda;
	$plan = datePlan($date);
	$staff = staffList();
	foreach($staff as $k => $s){
		$stPln = staffPlan($s['staff_id'], $plan['plan_id']);
		$token = staffTaken($s['staff_id'], $plan['plan_id']);
		$staff[$k]['allBalance']   = $stPln['vacations_balance'] + $stPln['previous_balance'];
		$staff[$k]['totalBalance'] = $stPln['vacations_balance'] + $stPln['previous_balance'] - $token;
		$staff[$k]['validBalance'] = staffBalance($s['staff_id'], $plan['plan_id'], innerDate($date));
		$staff[$k]['totalToken']   = $token;
		$staff[$k]['lastVac']      = staffLastVac($s['staff_id']);
	}	
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/hcp/vac/staffbalances.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>