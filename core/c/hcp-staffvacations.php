<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
require_once($rootPath."core/m/vacations.php");
$plan = getPlan();

$mid = dateMonth($tda);

$mths = $sql->query("SELECT a.`plan_month_id`, b.`plan_title`, c.`ar_month_name` FROM `plan_months` a, `plans` b, `ar_months` c WHERE a.`plan_month_id` <= ".$mid." AND b.`plan_id` = a.`plan_id` AND c.`ar_month_id` = a.`ar_month_id` ORDER BY `plan_month_id` DESC LIMIT 6");

if((isset($_GET['report']) && intval($_GET['report']) > 0) && (canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('acp', $_SESSION['staff']['rolls']))){
	$typs = getVacations();
	$vacs = monthVacs(intval($_GET['report']));
}elseif((isset($_GET['mid']) && intval($_GET['mid']) > 0) && (canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('acp', $_SESSION['staff']['rolls']))){
	$typs = getVacations();
	$vacs = monthVacs(intval($_GET['mid']));
}elseif((isset($_GET['m']) && $_GET['m']) == "archive" && (canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('acp', $_SESSION['staff']['rolls']))){
	$typs = getVacations();
	$vacs = archiveVacs();
}else{
	if(canSeePage('ccp', $_SESSION['staff']['rolls'])){
		$typs = getVacations();
		$vacs = staffVacs($plan['plan_id'], 0);
	}elseif(canSeePage('hcp', $_SESSION['staff']['rolls'])){
		$typs = getVacations();
		$vacs = staffVacs($plan['plan_id']);
	}elseif(canSeePage('dcp', $_SESSION['staff']['rolls'])){
		$typs = getVacations(TRUE);
		$vacs = staffVacs($plan['plan_id'], -1, $_SESSION['staff']['dept_id'], "d");
	}elseif(canSeePage('scp', $_SESSION['staff']['rolls'])){
		$typs = getVacations(TRUE);
		$vacs = staffVacs($plan['plan_id'], -2, $_SESSION['staff']['staff_id'], "s");
	}else{
		include($rootPath."core/v/banned.php");
		die();
	}
}
include($rootPath."core/v/header.php");
include($rootPath."core/v/hcp/vac/staffvacations.php");
include($rootPath."core/v/footer.php");
?>