<?php
function getPlans($limit = 0){
	$sql = $GLOBALS['sql'];
	$ext = $limit > 0 ? " LIMIT ".$limit : "";
	$plans = $sql->query("SELECT * FROM `plans` ORDER BY `plan_start_date` DESC".$ext);
	if(count($plans) > 0){
		return $plans;
	}
	return false;
}

function getPlan($plan_id = 0){
	$sql = $GLOBALS['sql'];
	$cond = $plan_id > 0 ? " WHERE `plan_id` = ".$plan_id : "";
	$plans = $sql->query("SELECT * FROM `plans`".$cond." ORDER BY `plan_start_date` DESC LIMIT 1");
	if(count($plans) > 0){
		return $plans[0];
	}
	return false;
}

function getDatePlan($date = NULL){
	$sql = $GLOBALS['sql'];
	if(is_null($date))  $date = date("Ymd")."A";
	if($date[8] == "A") $date = innerDate($date);
	$plans = $sql->query("SELECT * FROM `plans` WHERE `plan_start_date` <= '".$date."' AND `plan_end_date` >= '".$date."' ORDER BY `plan_id` DESC LIMIT 1");
	if(count($plans) > 0){
		return $plans[0];
	}
	return getPlan();
}

function addPlan($title, $start, $end){
	$sql = $GLOBALS['sql'];
	if($sql->simple("INSERT INTO `plans` VALUES ( '', '".$title."', '".sysDate($start)."', '".sysDate($end)."' )")) return true;
	return false;
}

function editPlan($title, $start, $end, $id){
	$sql = $GLOBALS['sql'];
	if($sql->simple("UPDATE `plans` SET `plan_title` = '".$title."', `plan_start_date` = '".sysDate($start)."', `plan_end_date` = '".sysDate($end)."' WHERE `plan_id` = ".$id)) return true;
	return false;
}

function deletePlan($id){
	$sql = $GLOBALS['sql'];
	if($sql->simple("DELETE FROM `plans` WHERE `plan_id` = ".$id)) return true;
	return false;
}

function createPlanMonths($plan_id){
	$sql = $GLOBALS['sql'];
	$plans = $sql->query("SELECT * FROM `plans` WHERE `plan_id` = ".$plan_id);
	if(count($plans) > 0){
		$sd = $plans[0]['plan_start_date'];
		$ed = $plans[0]['plan_end_date'];
		$ms = ceil(datesDif($sd, $ed) / 30);
		$s  = outDate($sd);
		$m  = round($s['m']);
		$y  = round($s['y']);
		$t  = round($s['t']);
		$ok = 0;
		for($i = 1; $i <= $ms; $i++){
			$nm = $m + $i - 1;
			$mm = $nm > 9 ? $nm : '0'.$nm;
			$md = $y.$mm.'01H';
			$rd = reverseDate($md);
			if($sql->simple("INSERT INTO `plan_months` VALUES ( '', ".$plan_id.", ".$nm.", '".$rd."' )")) $ok++;
		}
		if($ok == $ms) return true;
	}
	return false;
}

function planMonths($plan_id){
	$sql = $GLOBALS['sql'];
	$plans = $sql->query("SELECT * FROM `plans` WHERE `plan_id` = ".$plan_id);
	if(count($plans) > 0){
		$months = $sql->query("SELECT * FROM `plan_months` WHERE `plan_id` = ".$plan_id." ORDER BY `plan_month_id` ASC");
		if(count($months) > 0){
			return $months;
		}else{
			if(createPlanMonths($plan_id)) return planMonths($plan_id);
		}
	}
	return false;
}

function getMonth($mid){
	$sql = $GLOBALS['sql'];
	$month = $sql->query("SELECT a.*, b.`ar_month_name`, c.`plan_title` FROM `plan_months` a, `ar_months` b, `plans` c WHERE b.`ar_month_id` = a.`ar_month_id` AND c.`plan_id` = a.`plan_id` AND a.`plan_month_id` = ".$mid." LIMIT 1");
	if(count($month) > 0){
		return $month[0];
	}
	return false;
}

function getPreMonth($mid){
	$sql = $GLOBALS['sql'];
	$month = $sql->query("SELECT a.*, b.`ar_month_name`, c.`plan_title` FROM `plan_months` a, `ar_months` b, `plans` c WHERE b.`ar_month_id` = a.`ar_month_id` AND c.`plan_id` = a.`plan_id` AND a.`plan_month_id` < ".$mid." ORDER BY `plan_month_id` DESC LIMIT 1");
	if(count($month) > 0){
		return $month[0];
	}
	return false;
}

function createPlanMonthDays($plan_month_id){
	$sql = $GLOBALS['sql'];
	$months = $sql->query("SELECT * FROM `plan_months` WHERE `plan_month_id` = ".$plan_month_id);
	if(count($months) > 0){
		$sd = $months[0]['plan_month_start_date'];
		$ok = 0;
		for($i = 1; $i <= 30; $i++){
			$dx = datePlusDays( $sd, ( $i - 1 ) );
			$wi = dayOfDate($dx);
			$ds = Fld("week_days", "week_day_id", $wi, "week_day_off");
			if($sql->simple("INSERT INTO `plan_month_days` VALUES ( '', ".$plan_month_id.", ".$wi.", ".$i.", '".$dx."', ".$ds." )")) $ok++;
		}
		if($ok == 30) return true;
	}
	return false;
}

function planMonthsChange($plan_id, array $months){
	$sql = $GLOBALS['sql'];
	$c = count($months);
	$ok = 0;
	foreach($months as $month_id => $start_date){
		if($sql->simple("UPDATE `plan_months` SET `plan_month_start_date` = '".sysDate($start_date)."' WHERE `plan_month_id` = ".$month_id." AND `plan_id` = ".$plan_id." LIMIT 1")) $ok++;
	}
	
	if($ok == $c) return true;
	return false;
}

function planMonthDays($plan_month_id){
	$sql = $GLOBALS['sql'];
	$months = $sql->query("SELECT * FROM `plan_months` WHERE `plan_month_id` = ".$plan_month_id);
	if(count($months) > 0){
		$days = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$plan_month_id." ORDER BY `day_id` ASC");
		if(count($days) > 0){
			return $days;
		}else{
			if(createPlanMonthDays($plan_month_id)) planMonthDays($plan_month_id);
		}
	}
	return false;
}

function monthDays($plan_month_id){
	$sql = $GLOBALS['sql'];
	$q = $sql->query("SELECT COUNT(*) AS `days` FROM `plan_month_days` WHERE `plan_month_id` = ".$plan_month_id);
	if($q[0]['days'] > 0) return true;
	return false;
}

function dateMonth($date){
	$sql = $GLOBALS['sql'];
	$mnths = $sql->query("SELECT `plan_month_id` FROM `plan_month_days` WHERE `day_date` = '".$date."'");
	if(count($mnths) > 0) return $mnths[0]['plan_month_id'];
	return false;
}

function datePlan($date){
	$sql = $GLOBALS['sql'];
	$mid = dateMonth($date);
	if($mid){
		$plns = $sql->query("SELECT * FROM `plans` WHERE `plan_id` IN ( SELECT `plan_id` FROM `plan_months` WHERE `plan_month_id` = ".$mid.")");
		if(count($plns) > 0) return $plns[0];
	}
	return getPlan();
}

function getWorkShifts($mid){
	$sql = $GLOBALS['sql'];
	$wss = $sql->query("SELECT * FROM `plan_month_shifts` WHERE `plan_month_id` = ".$mid." ORDER BY `shift_in` ASC");
	if(count($wss) > 0){
		return $wss;
	}else{
		addWorkShift($mid, "الدوام الصباحي", "08:00", "11:45");	
		addWorkShift($mid, "الدوام المسائي", "13:30", "17:00");
		return getWorkShifts($mid);
	}
}

function addWorkShift($mid, $title, $in, $out){
	$sql = $GLOBALS['sql'];
	if($sql->simple("INSERT INTO `plan_month_shifts` VALUES ( '', ".$mid.", '".$title."', '".$in."', '".$out."' )")) return true;
	return false;
}

function editWorkShift($sid, $title, $in, $out){
	$sql = $GLOBALS['sql'];
	if($sql->simple("UPDATE `plan_month_shifts` SET `shift_title` = '".$title."', `shift_in` = '".$in."', `shift_out` = '".$out."' WHERE `shift_id` = ".$sid)) return true;
	return false;
}

function deleteWorkShift($sid){
	$sql = $GLOBALS['sql'];
	if($sql->simple("DELETE FROM `plan_month_shifts` WHERE `shift_id` = ".$sid)) return true;
	return false;
}

function staffPlan($staff_id, $plan_id){
	$sql = $GLOBALS['sql'];
	$sp  = $sql->query("SELECT * FROM `staff_plans` WHERE `staff_id` = ".$staff_id." AND `plan_id` = ".$plan_id." LIMIT 1");
	if(count($sp) > 0){
		return $sp[0];
	}else{
		if($sql->simple("INSERT INTO `staff_plans` VALUES ( '', ".$plan_id.", ".$staff_id.", 0, 0, 0, 0, 0, 0, 0, 0 )")){
			return staffPlan($staff_id, $plan_id);
		}else{
			return false;	
		}
	}
}

function staffTimesheet($staff_id, $month_id){
	$sql = $GLOBALS['sql'];
	$timesheet = $sql->query("SELECT a.*, b.`week_day_id`, b.`day_order`, b.`day_date`, c.`staff_fullname`, d.`shift_title`, e.`week_day_name` FROM `staff_timesheet` a, `plan_month_days` b, `staff` c, `plan_month_shifts` d, `week_days` e WHERE b.`day_id` = a.`day_id` AND c.`staff_id` = a.`staff_id` AND d.`shift_id` = a.`shift_id` AND e.`week_day_id` = b.`week_day_id` AND a.`plan_month_id` = ".$month_id." AND a.`staff_id` = ".$staff_id." ORDER BY a.`day_id` ASC, a.`shift_id` ASC");
	if(count($timesheet) > 0){
		return $timesheet;
	}else{
		if(setStaffTimesheet($staff_id, $month_id)) return staffTimesheet($staff_id, $month_id);
		return false;
	}
}

function dayTimesheet($day_id, $month_id){
	$sql = $GLOBALS['sql'];
	$timesheet = $sql->query("SELECT a.*, b.`week_day_id`, b.`day_order`, b.`day_date`, c.`staff_fullname`, d.`shift_title`, e.`week_day_name` FROM `staff_timesheet` a, `plan_month_days` b, `staff` c, `plan_month_shifts` d, `week_days` e WHERE b.`day_id` = a.`day_id` AND c.`staff_id` = a.`staff_id` AND d.`shift_id` = a.`shift_id` AND e.`week_day_id` = b.`week_day_id` AND a.`plan_month_id` = ".$month_id." AND a.`day_id` = ".$day_id." ORDER BY c.`staff_fullname` ASC, a.`shift_id` ASC");
	if(count($timesheet) > 0){
		return $timesheet;
	}else{
		if(setTimesheet($month_id)) return dayTimesheet($day_id, $month_id);
		return false;
	}
}

function setTimesheet($month_id){
	$sql = $GLOBALS['sql'];
	$days = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$month_id." ORDER BY `day_id` ASC LIMIT 30");
	$shifts = $sql->query("SELECT * FROM `plan_month_shifts` WHERE `plan_month_id` = ".$month_id." ORDER BY `shift_id` ASC");
	$sts = $sql->query("SELECT DISTINCT(`staff_id`) AS `staffId` FROM `dept_staff` WHERE `dept_joindate` < '".reverseDate($days[28]['day_date'])."'");
	$ok = 0;
	foreach($days as $d){
		foreach($shifts as $s){
			foreach($sts as $st){
				if($sql->simple("INSERT INTO `staff_timesheet` VALUES ( '', ".$st['staffId'].", ".$month_id.", ".$d['day_id'].", ".$s['shift_id'].", '".$s['shift_in']."', '".$s['shift_out']."', '".$d['day_status']."', '' )")) $ok++;	
			}
		}
	}
	if($ok > 0) return true;
	return false;
}

function setStaffTimesheet($staff_id, $month_id){
	$sql = $GLOBALS['sql'];
	$days = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$month_id." ORDER BY `day_id` ASC LIMIT 30");
	$shifts = $sql->query("SELECT * FROM `plan_month_shifts` WHERE `plan_month_id` = ".$month_id." ORDER BY `shift_id` ASC");
	$ok = 0;
	foreach($days as $d){
		foreach($shifts as $s){
			if($sql->simple("INSERT INTO `staff_timesheet` VALUES ( '', ".$staff_id.", ".$month_id.", ".$d['day_id'].", ".$s['shift_id'].", '".$s['shift_in']."', '".$s['shift_out']."', '".$d['day_status']."', '' )")) $ok++;	
		}
	}
	if($ok > 0) return true;
	return false;
}


function saveTimesheet($in, $out, $status, $comment, $id){
	$sql = $GLOBALS['sql'];
	if($sql->simple("UPDATE `staff_timesheet` SET `in_time` = '".$in."', `out_time` = '".$out."', `status` = '".$status."', `comment` = '".$comment."' WHERE `id` = ".$id)) return true;
	return false;
}

function staffMonthlySummary($staff_id, $month_id){
	$sql = $GLOBALS['sql'];
	$sms = $sql->query("SELECT * FROM `staff_monthly_summary` WHERE `staff_id` = ".$staff_id." AND `plan_month_id` = ".$month_id." ORDER BY `id` DESC LIMIT 1");
	if(count($sms) > 0){
		return $sms[0];
	}else{
		$sql->simple("INSERT INTO `staff_monthly_summary` VALUES ('', ".$staff_id.", ".$month_id.", 0, 0, 0, 0, 0, 0, 0, '', 0) ");
		return staffMonthlySummary($staff_id, $month_id);
	}
}

function saveMonthlySummary($dr, $dc, $ar, $ac, $hd, $er, $ec, $comment, $id){
	$sql = $GLOBALS['sql'];
	if($sql->simple("UPDATE `staff_monthly_summary` SET `delays_real` = ".$dr.", `delays_count` = ".$dc.", `absence_real` = ".$ar.", `absence_count` = ".$ac.", `half_days` = ".$hd.", `extras_real` = ".$er.", `extras_count` = ".$ec.", `comment` = '".$comment."', `last_updates` = ".time()." WHERE `id` = ".$id)) return true;
	return false;
}

function staffExtras($staff_id, $month_id){
	$sql = $GLOBALS['sql'];
	return $sql->query("SELECT * FROM `staff_extras` WHERE `staff_id` = ".$staff_id." AND `plan_month_id` = ".$month_id." ORDER BY `extra_id` ASC");
}

function newExtra($sid, $mid, $day, $opr, $from, $to, $comment){
	$sql = $GLOBALS['sql'];
	if($sql->simple("INSERT INTO `staff_extras` VALUES ( '', ".$sid.", ".$mid.", '".$day."', ".$opr.", '".$from."', '".$to."', '".$comment."' )")) return true;
	return false;
}

function editExtra($day, $opr, $from, $to, $comment, $eid){
	$sql = $GLOBALS['sql'];
	if($sql->simple("UPDATE `staff_extras` SET `extra_day` = '".$day."', `extra_opr` = ".$opr.", `extra_from` = '".$from."', `extra_to` = '".$to."', `comment` = '".$comment."' WHERE `extra_id` = ".$eid)) return true;
	return false;
}

function deleteExtra($eid){
	$sql = $GLOBALS['sql'];
	if($sql->simple("DELETE FROM `staff_extras` WHERE `extra_id` = ".$eid)) return true;
	return false;
}

function staffMoneySheet($staff_id, $month_id){
	$sql = $GLOBALS['sql'];
	$moneysheet = $sql->query("SELECT * FROM `staff_moneysheet` WHERE `staff_id` = ".$staff_id." AND `plan_month_id` = ".$month_id." ORDER BY `id` DESC LIMIT 1");
	if(count($moneysheet) > 0){
		return $moneysheet[0];
	}else{
		$m = getMonth($month_id);
		$plan_id = $m['plan_id'];
		$stPln = staffPlan($staff_id, $plan_id);
		$h = ( $month_id%6 == 0 ) ? round($stPln['housing'], 2) / 2 : 0;
		$sql->simple("INSERT INTO `staff_moneysheet` VALUES ('', ".$staff_id.", ".$month_id.", ".$stPln['salary'].", ".$stPln['transport'].", ".$h.", ".$stPln['worknature'].", 0, 0, 0, 0, 0, 0, 0, 0, ".$stPln['isp'].", ".$stPln['iso'].", '', 0) ");
		return staffMoneySheet($staff_id, $month_id);
	}
}

function saveStaffMoneySheet(array $arr, $id){
	$sql = $GLOBALS['sql'];
	$txt = "UPDATE `staff_moneysheet` SET ";
	$out = array();
	foreach($arr as $fld => $vlu){
		$out[] = "`".$fld."` = '".$vlu."'";
	}
	$txt .= implode(", ", $out)." WHERE `id` = ".$id;
	if($sql->simple($txt)) return true;
	return false;
}

function getMoneySheet($mid){
	$sql = $GLOBALS['sql'];
	$moneysheet = $sql->query("SELECT * FROM `staff_moneysheet` WHERE `plan_month_id` = ".$mid." AND `last_update` > 0 ORDER BY `last_update` ASC, `id` ASC");
	return $moneysheet;
}
?>