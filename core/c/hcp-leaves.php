<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
require_once($rootPath."core/m/leaves.php");

$mid = dateMonth($tda);
$pln = datePlan($tda);

$mths = $sql->query("SELECT a.`plan_month_id`, b.`plan_title`, c.`ar_month_name` FROM `plan_months` a, `plans` b, `ar_months` c WHERE a.`plan_month_id` <= ".$mid." AND b.`plan_id` = a.`plan_id` AND c.`ar_month_id` = a.`ar_month_id` ORDER BY `plan_month_id` DESC LIMIT 6");

if(isset($_REQUEST['act']) && $_REQUEST['act'] != ""){
	$act = $_REQUEST['act'];
	switch($act){
		case 'delete':
			if(isset($_GET['id']) && intval($_GET['id']) > 0) deleteLeave(intval($_GET['id'])); 
			Redir("index.php?c=hcp-leaves");
		break;
		case 'status':
			if(isset($_GET['id'], $_GET['status']) && intval($_GET['id']) > 0){
				$arr = array();
				if(canSeePage('hcp', $_SESSION['staff']['rolls'])){
					$arr['hr_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time().":".intval($_GET['status']);
					$cntu = true;
				}elseif(canSeePage('dcp', $_SESSION['staff']['rolls'])){
					$arr['dm_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time().":".intval($_GET['status']);
					$cntu = true;
				}else{
					$cntu = false;
				}
				if($cntu){
					$arr['leave_status'] = intval($_GET['status']);
					$id = intval($_GET['id']);
					if(saveLeave($arr, $id)) Redir("index.php?c=hcp-leaves");
				}
				include($rootPath."core/v/banned.php");
				die();
			}
		break;
		case 'add':
			if(canSeePage('hcp', $_SESSION['staff']['rolls'])){
				$staff    = staffList();
			}else{
				$staff_id = $_SESSION['staff']['staff_id'];
			}
		break;
		case 'edit':
			if(isset($_GET['id']) && intval($_GET['id']) > 0) $l = getLeave(intval($_GET['id']));
			else Redir("index.php?c=hcp-leaves");
		break;
		case 'save':
			if(saveLeave($_POST['l'], $_POST['id'])) Redir("index.php?c=hcp-leaves");
		break;
	}
}
if((isset($_GET['report']) && intval($_GET['report']) > 0) && (canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('acp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']))){
	$lvs = getLeaves(intval($_GET['report']), "m");
}elseif((isset($_GET['mid']) && intval($_GET['mid']) > 0) && (canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('acp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']))){
	$lvs = getLeaves(intval($_GET['mid']), "m");
}else{
	if(canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls'])){
		$lvs = getLeaves($pln['plan_id'], "p");	
	}elseif(canSeePage('dcp', $_SESSION['staff']['rolls'])){
		$lvs = getDeptLeaves($_SESSION['staff']['dept_id'], $pln['plan_id'], "p");
	}elseif(canSeePage('scp', $_SESSION['staff']['rolls'])){
		$lvs = getStaffLeaves($_SESSION['staff']['staff_id'], $pln['plan_id'], "p");
	}else{
		include($rootPath."core/v/banned.php");
		die();
	}
}

//print_r($_SESSION);
//print_r($lvs);
	
include($rootPath."core/v/header.php");

if(isset($act) && $act != "" && file_exists($rootPath."core/v/hcp/leaves/".$act.".php")){
	include($rootPath."core/v/hcp/leaves/".$act.".php");
}else{
	include($rootPath."core/v/hcp/leaves.php");
}

include($rootPath."core/v/footer.php");
?>