<?php
function getLeaves($id, $flag = "m"){
	$sql = $GLOBALS['sql'];
	$txt = "SELECT * FROM `staff_leaves`";
	switch($flag){
		case 's':
			$txt .= " WHERE `staff_id` = ".$id;
		break;
		case 'p':
			$pln = getPlan($id);
			$sd  = aDate($pln['plan_start_date']);
			$ed  = aDate($pln['plan_end_date']);
			$txt .= " WHERE `leave_date` >= '".$sd."' AND `leave_date` <= '".$ed."'";
		break;
		case 'm':
		default:
			$days = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$id);
			$sd   = $days[0]['day_date'];
			$ed   = $days[29]['day_date'];
			$txt .= " WHERE `leave_date` >= '".$sd."' AND `leave_date` <= '".$ed."'";
		break;
	}
	$txt .= " AND `leave_status` > -1";
	return $sql->query($txt);
}

function getLeave($id){
	$sql = $GLOBALS['sql'];
	$lvs = $sql->query("SELECT * FROM `staff_leaves` WHERE `leave_id` = ".$id);
	return $lvs[0];
}

function getStaffLeaves($staff_id, $id, $flag = "m"){
	$sql = $GLOBALS['sql'];
	$txt = "SELECT * FROM `staff_leaves`";
	switch($flag){
		case 'p':
			$pln = getPlan($id);
			$sd  = aDate($pln['plan_start_date']);
			$ed  = aDate($pln['plan_end_date']);
			$txt .= " WHERE `leave_date` >= '".$sd."' AND `leave_date` <= '".$ed."'";
		break;
		case 'm':
		default:
			$days = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$id);
			$sd   = $days[0]['day_date'];
			$ed   = $days[29]['day_date'];
			$txt .= " WHERE `leave_date` >= '".$sd."' AND `leave_date` <= '".$ed."'";
		break;
	}
	$txt .= " AND `staff_id` = ".$staff_id;
	return $sql->query($txt);
}

function getDeptLeaves($dept_id, $id, $flag = "m"){
	$sql = $GLOBALS['sql'];
	$txt = "SELECT * FROM `staff_leaves`";
	switch($flag){
		case 'p':
			$pln = getPlan($id);
			$sd  = aDate($pln['plan_start_date']);
			$ed  = aDate($pln['plan_end_date']);
			$txt .= " WHERE `leave_date` >= '".$sd."' AND `leave_date` <= '".$ed."'";
		break;
		case 'm':
		default:
			$days = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$id);
			$sd   = $days[0]['day_date'];
			$ed   = $days[29]['day_date'];
			$txt .= " WHERE `leave_date` >= '".$sd."' AND `leave_date` <= '".$ed."'";
		break;
	}
	$txt .= " AND `staff_id` IN ( SELECT `staff_id` FROM `dept_staff` WHERE `dept_id` = ".$dept_id." ) ";
	return $sql->query($txt);
}

function staffLeaveOrder($staff_id, $id, $flag = "m"){
	$sql = $GLOBALS['sql'];
	$txt = "SELECT * FROM `staff_leaves`";
	switch($flag){
		case 'p':
			$out = "leave_in_year_order";
			$pln = getPlan($id);
			$sd  = aDate($pln['plan_start_date']);
			$ed  = aDate($pln['plan_end_date']);
			$txt .= " WHERE `leave_date` >= '".$sd."' AND `leave_date` <= '".$ed."'";
		break;
		case 'm':
		default:
			$out  = "leave_in_month_order";
			$days = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$id);
			$sd   = $days[0]['day_date'];
			$ed   = $days[29]['day_date'];
			$txt .= " WHERE `leave_date` >= '".$sd."' AND `leave_date` <= '".$ed."'";
		break;
	}
	$txt .= " AND `staff_id` = ".$staff_id." ORDER BY `leave_date` DESC LIMIT 1";
	$leaves = $sql->query($txt);
	if(count($leaves) > 0) return intval($leaves[0][$out]) + 1;
	return 1;
}

function saveLeave(array $arr, $id = 0){
	$sql = $GLOBALS['sql'];	
	$cnd = array();
	$ld  = sysDate($arr['leave_date']);
	if($ld[8] == "H") $date = aDate($ld);
	else $date = $ld;
	foreach($arr as $fld => $vlu){
		if($fld == "leave_date"){
			$vlu = $date;
		}
		if($fld == "leave_in_month_order" && $vlu < 1){
			$mid = dateMonth($date);
			$vlu = staffLeaveOrder($arr['staff_id'], $mid, "m");
		}
		if($fld == "leave_in_year_order" && $vlu < 1){
			$pln = datePlan($date);
			$vlu = staffLeaveOrder($arr['staff_id'], $pln['plan_id'], "p");
		}
		if($fld == "leave_status" && $vlu < 0 && isset($arr['staff_id']) && intval($arr['staff_id']) > 0){
			$rls = getStaffRolls($arr['staff_id']);
			if(in_array("ccp", $rls)){
				$vlu = 2;
			}elseif(in_array("dcp", $rls)){
				$vlu = 1;
			}else{
				$vlu = 0;
			}
			
		}
		$cnd[] = "`".$fld."` = '".$vlu."'";	
	}
	$str = implode(", ", $cnd);
	if(intval($id) > 0) $txt = "UPDATE `staff_leaves` SET ".$str." WHERE `leave_id` = ".intval($id);
	else $txt = "INSERT INTO `staff_leaves` SET ".$str;
	if($sql->simple($txt)) return true;
	return false;
}

function deleteLeave($id){
	$sql = $GLOBALS['sql'];
	setStaffLeaveDay($id, 0);
	if(toArchive("staff_leaves", "leave_id", $id)){
		if($sql->simple("DELETE FROM `staff_leaves` WHERE `leave_id` = ".$id)) return true;
	}
	return false;	
}

function leaveStatus($st){
	switch($st){
		case -1:
			return "مرفوضة";
		break;
		case 0:
			return "أمام المدير المباشر";
		break;
		case 1:
			return "أمام المدير التنفيذي";
		break;
		case 2:
			return "مقبولة";
		break;
	}
}

function setStaffLeaveDay($leave_id, $st = 0){
	$sql = $GLOBALS['sql'];
	$leave = $sql->query("SELECT * FROM `staff_leaves` WHERE `leave_id` = ".$leave_id." AND `leave_status` = 2");
	if(count($leave) > 0){
		extract($leave[0]);
		$shft = " AND `shift_id` LIKE '%'";	
		$mid = dateMonth($leave_date);
		if($mid){
			$shs = $sql->query("SELECT `shift_id` FROM `plan_month_shifts` WHERE `plan_month_id` = ".$mid." AND `shift_in` <= '".$leave_from_time."' AND `shift_out` >= '".$leave_to_time."'");
			if(count($shs) > 0) $shft = " AND `shift_id` = ".$shs[0]['shift_id'];
		}
		$sql->simple("UPDATE `staff_timesheet` SET `status` = '0' WHERE `day_id` = ( SELECT `day_id` FROM `plan_month_days` WHERE `day_date` = '".$leave_date."' ) AND `staff_id` = ".$staff_id.$shft);			
		if($st > 0) $sql->simple("UPDATE `staff_timesheet` SET `status` = '".$st."' WHERE `day_id` = ( SELECT `day_id` FROM `plan_month_days` WHERE `day_date` = '".$leave_date."' ) AND `staff_id` = ".$staff_id.$shft);
		return true;
	}
	return false;
}
?>