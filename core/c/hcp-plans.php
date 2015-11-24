<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");

$r = isset($_GET['r']) ? $_GET['r'] : $_SESSION['staff']['rolls'][0];

if(canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('fcp', $_SESSION['staff']['rolls'])){
	
	if(isset($_POST['act'])){
		extract($_POST);
		switch($act){
			case 'add':
				if(addPlan($plan_title, $plan_start_date, $plan_end_date)) $notf = "تمت العملية بنجاح";
			break;
			case 'edit':
				if(editPlan($plan_title, $plan_start_date, $plan_end_date, $plan_id)) $notf = "تمت العملية بنجاح";
			break;
		}
	}
	
	if(isset($_GET['delete']) && intval($_GET['delete']) > 0){
		if(deletePlan(intval($_GET['delete']))) Redir("index.php?c=hcp-plans");
	}
	
	$plans = getPlans();
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/hcp/plans.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>