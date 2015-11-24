<?php
error_reporting(0);
session_start();
$ses_id = session_id();

require_once("inc/config.php");
require_once($rootPath."core/c/login.php");

$weekday  = arDate("l");
$tda = date("Ymd")."A";
$tdh = innerDate($tda);
$ta  = outDate($tda);
$th  = outDate($tdh);
$lwd = lastWorkDay(0);
$msg = newMessages($_SESSION['staff']['staff_id']);
$ims = getMessages($_SESSION['staff']['staff_id'], 0);

if(canSeePage("ccp", $_SESSION['staff']['rolls'])){
	$intf = true;
	$ivcs = getCount("SELECT `vacation_id` FROM `staff_vacations` WHERE `vacation_status` = 1");	
	$ilvs = getCount("SELECT `leave_id` FROM `staff_leaves` WHERE `leave_status` = 1");
}elseif(canSeePage("hcp", $_SESSION['staff']['rolls'])){
	$intf = true;
	$ivcs = getCount("SELECT `vacation_id` FROM `staff_vacations` WHERE `vacation_status` BETWEEN 0 AND 2");	
	$ilvs = getCount("SELECT `leave_id` FROM `staff_leaves` WHERE `leave_status` BETWEEN 0 AND 1");
}elseif(canSeePage("dcp", $_SESSION['staff']['rolls'])){
	$intf = true;
	$ivcs = getCount("SELECT `vacation_id` FROM `staff_vacations` WHERE `vacation_status` = 0 AND `staff_id` IN ( SELECT `staff_id` FROM `dept_staff` WHERE `dept_id` = ".$_SESSION['staff']['dept_id']." )");	
	$ilvs = getCount("SELECT `leave_id` FROM `staff_leaves` WHERE `leave_status` = 0 AND `staff_id` IN ( SELECT `staff_id` FROM `dept_staff` WHERE `dept_id` = ".$_SESSION['staff']['dept_id']." )");
}else{
	$intf = false;
}

/*if(isset($_GET['debug']) && $_GET['debug'] == "go"){
	$days = $sql->query("SELECT a.*, b.`day_status` FROM `staff_timesheet` a, `plan_month_days` b WHERE b.`day_id` = a.`day_id` AND a.`plan_month_id` = 13 AND b.`day_status` = 1 AND a.`status` = 0 ORDER BY a.`day_id` ASC");
	foreach($days as $d){
		$sql->simple("UPDATE `staff_timesheet` SET `status` = 1 WHERE `id` = ".$d['id']);
		echo "<br /> record[ ".$d['id']." ] done.";
	}
	
	$days = $sql->query("SELECT a.*, b.`day_status` FROM `staff_timesheet` a, `plan_month_days` b WHERE b.`day_id` = a.`day_id` AND a.`plan_month_id` = 13 AND b.`day_status` = 0 AND a.`status` = 1 ORDER BY a.`day_id` ASC");
	foreach($days as $d){
		$sql->simple("UPDATE `staff_timesheet` SET `status` = 0 WHERE `id` = ".$d['id']);
		echo "<br /> record[ ".$d['id']." ] done.";
	}
}*/

if(isset($_GET['c']) && $_GET['c'] != ""){
	$c = $_GET['c'];
}else{
	$c = "profile";	
}

require_once($rootPath."core/c/".$c.".php");
?>