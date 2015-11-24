<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
if(canSeePage('hcp', $_SESSION['staff']['rolls']) && isset($_GET['mid']) && intval($_GET['mid']) > 0){
	if(isset($_POST['act'])){
		extract($_POST);
		switch($act){
			case 'add':
				if(addWorkShift($mid, $title, $in, $out)) $notf = "تمت العملية بنجاح";
			break;
			case 'edit':
				if(editWorkShift($sid, $title, $in, $out)) $notf = "تمت العملية بنجاح";
			break;
		}
	}
	
	if(isset($_GET['delete']) && intval($_GET['delete']) > 0){
		if(deleteWorkShift(intval($_GET['delete']))) Redir("index.php?c=workshifts&mid=".intval($_GET['mid']));
	}
	
	$wss = getWorkShifts(intval($_GET['mid']));
	$m = $sql->query("SELECT a.*, b.`ar_month_name`, c.`plan_title` FROM `plan_months` a, `ar_months` b, `plans` c WHERE a.`plan_month_id` = ".intval($_GET['mid'])." AND b.`ar_month_id` = a.`ar_month_id` AND c.`plan_id` = a.`plan_id` LIMIT 1");
	
	include($rootPath."core/v/hcp/workshifts.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>