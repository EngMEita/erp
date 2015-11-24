<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");

if(canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('fcp', $_SESSION['staff']['rolls'])){
	
	$staff = staffList();
	
	if(isset($_GET['plan_id']) && intval($_GET['plan_id']) > 0) $plan = getPlan(intval($_GET['plan_id']));
	else $plan = getPlan();
	
	$mid = dateMonth($tda);
	$m    = getMonth($mid);
	
	if($m['ar_month_id'] == 12) $p = getMonth($mid);
	if($m['ar_month_id'] == 1)  $p = getPreMonth($mid);
	
	if(isset($p)){
		$days = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$p['plan_month_id']." ORDER BY `day_date` DESC LIMIT 1");
		$cda = $days[0]['day_date'];
		$pre = array();
		$i = 0;
		foreach($staff as $s){
			$stPln = staffPlan($s['staff_id'], $p['plan_id']);
			$token = staffTaken($s['staff_id'], $p['plan_id']);
			$pre[$i] = $stPln['vacations_balance'] + $stPln['previous_balance'] - $token;
			$i++;
		}
	}
		
	if(isset($_POST['act']) && $_POST['act'] == "setStaffPlans"){
		$ok = 0;
		foreach($_POST['ids'] as $id){
			if($sql->simple("UPDATE `staff_plans` SET `salary` = '".$_POST['salary'][$id]."', `housing` = '".$_POST['housing'][$id]."', `transport` = '".$_POST['transport'][$id]."', `worknature` = '".$_POST['worknature'][$id]."', `isp` = '".$_POST['isp'][$id]."', `iso` = '".$_POST['iso'][$id]."', `vacations_balance` = '".$_POST['vacations_balance'][$id]."', `previous_balance` = '".$_POST['previous_balance'][$id]."' WHERE `id` = ".$id)) $ok++;
		}
		if($ok > 0) $notf = "تم التحديث بنجاح";
	}
	
	
	$sps   = array();
	$i = 0;
	foreach($staff as $s){
		$sps[$i]['s'] = $s;
		$sps[$i]['p'] = staffPlan($s['staff_id'], $plan['plan_id']);
		$i++;
	}	
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/hcp/staffplans.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>