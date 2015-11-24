<?php
function getVacations($forStaffOnly = false, $flds = "*"){
	$sql = $GLOBALS['sql'];
	
	$cond = "";
	
	if($forStaffOnly){
		$cond = "WHERE `vacation_type_status` = 1";
	}
	
	$vac = $sql->query("SELECT ".$flds." FROM `vacation_types` ".$cond." ORDER BY `vacation_type_id` ASC");
	
	if(count($vac) > 0){
		return $vac;
	}
	
	$arr = array("vacation_type_title" => "إدارية", "vacation_type_from_balance" => 1, "vacation_type_status" => 1);
	
	if(saveVacation($arr)){
		return getVacations(false);
	}
	
	return false;
}

function getVacation($id){
	$sql = $GLOBALS['sql'];
	$vac = $sql->query("SELECT * FROM `vacation_types` WHERE `vacation_type_id` = ".$id." LIMIT 1");
	if(count($vac) > 0){
		return $vac[0];
	}	
	return false;
}

function saveVacation(array $arr, $id = NULL){
	$sql = $GLOBALS['sql'];	
	$cnd = array();
	
	foreach($arr as $fld => $vlu){
		$cnd[] = "`".$fld."` = '".$vlu."'";	
	}
	
	$str = implode(", ", $cnd);
	
	if(intval($id) > 0){
		$txt = "UPDATE `vacation_types` SET ".$str." WHERE `vacation_type_id` = ".intval($id);
	}else{
		$txt = "INSERT INTO `vacation_types` SET ".$str;
	}
	
	if($sql->simple($txt)){
		return true;
	}
	
	return false;
}

function deleteVacation($id){
	$sql = $GLOBALS['sql'];
	if(toArchive("vacation_types", "vacation_type_id", $id)){
		if($sql->simple("DELETE FROM `vacation_types` WHERE `vacation_type_id` = ".$id)){
			return true;
		}
	}
	return false;
}

function staffBalance($staff_id, $plan_id, $date = NULL){
	if(is_null($date)) $date = $GLOBALS['tdh'];
	$stPln = staffPlan($staff_id, $plan_id);
	$token = staffTaken($staff_id, $plan_id);
	return balanceCalc($stPln['vacations_balance'], $stPln['previous_balance'], $token, $date);
}

function balanceCalc($balance, $previous, $token, $hdate){
	$hdp   = outDate($hdate);
	$vom   = round($hdp['m']); //vacation order month
	$vcm   = ( $vom > 11 ) ? $vom : ( $vom - 1 ); //vacation calc month
	$vvb   = ( $balance / 12 ) * $vcm; //valid vacation balance
	//$tvb   = round( ( ( $vvb * ( 12 / 11 ) ) + $previous - $token ) ); //total valid balance
	//$tvb   = floor( ( $vvb + $previous - $token ) * ( 12 / 11 ) ); //total valid balance
	$tvb   = floor( ( $vvb + $previous - $token ) ); //total valid balance
	return $tvb > 0 ? $tvb : 0;
}

function staffTaken($staff_id, $plan_id){
	$sql = $GLOBALS['sql'];
	$vcs = $sql->query("SELECT * FROM `staff_vacations` WHERE `staff_id` = ".$staff_id." AND `vacation_type_id` IN ( SELECT `vacation_type_id` FROM `vacation_types` WHERE `vacation_type_from_balance` = 1 ) AND `vacation_status` >= 2");
	if(count($vcs) > 0){
		$t = 0;
		foreach($vcs as $vc){
			$t += planVacDays($plan_id, $vc['vacation_id']);
		}
		return $t;
	}
	return 0;
}

function vacDays($vac_id){
	$sql = $GLOBALS['sql'];
	$v   = $sql->query("SELECT * FROM `staff_vacations` WHERE `vacation_id` = ".$vac_id);
	$out = array();
	if(count($v) > 0){
		$sdt = $v[0]['vacation_startdate'];
		$dur = $v[0]['vacation_duration'];
		for($i = 0; $i < $dur; $i++){
			$d = datePlusDays($sdt, $i);
			$out[] = array("H" => innerDate($d), "A" => $d);
		}
	}
	return $out;
}

function vacDaysA($vac_id){
	$sql = $GLOBALS['sql'];
	$v   = $sql->query("SELECT * FROM `staff_vacations` WHERE `vacation_id` = ".$vac_id);
	$out = array();
	if(count($v) > 0){
		$sdt = $v[0]['vacation_startdate'];
		$dur = $v[0]['vacation_duration'];
		for($i = 0; $i < $dur; $i++){
			$out[$i] = datePlusDays($sdt, $i);
		}
	}
	return $out;
}


function planVacDays($plan_id, $vac_id){
	$sql = $GLOBALS['sql'];
	$p   = $sql->query("SELECT * FROM `plans` WHERE `plan_id` = ".$plan_id);
	if(count($p) > 0){
		$psd = $p[0]['plan_start_date'];
		$ped = $p[0]['plan_end_date'];
		$dys = vacDays($vac_id);
		$cnt = 0;
		foreach($dys as $dy){
			if( ( $dy['H'] >= $psd ) && ( $dy['H'] <= $ped ) ) $cnt++;
		}
		return $cnt;
	}
	return 0;
}

function vacStatus($status){
	switch($status){
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
			return "مقبولة ' تنتظر الطباعة '";
		break;
		case 3:
			return "مقبولة";
		break;
	}
}

function staffLastVac($staff_id, $s = 0){
	$sql = $GLOBALS['sql'];
	$vac = $sql->query("SELECT a.*, b.`vacation_type_title` FROM `staff_vacations` a, `vacation_types` b WHERE `staff_id` = ".$staff_id." AND `vacation_status` >= 2 AND b.`vacation_type_id` = a.`vacation_type_id` ORDER BY `vacation_id` DESC LIMIT ".$s.",1");
	if(count($vac) > 0){
		return $vac[0];
	}
	return false;
}

function staffVacs($plan_id, $st = -1, $id = NULL, $flag = NULL){
	$sql = $GLOBALS['sql'];
	$flags = array("d", "s");
	if(intval($id) > 0 && in_array($flag, $flags)){
		switch($flag){
			case 'd':
				$flgCnd = " AND c.`staff_id` IN ( SELECT `staff_id` FROM `dept_staff` WHERE `dept_id` = ".intval($id)." ) ";
			break;
			case 's':
				$flgCnd = " AND c.`staff_id` = ".intval($id);
			break;
		}
	}else $flgCnd = "";
	
	$pln = $sql->query("SELECT * FROM `plans` WHERE `plan_id` = ".$plan_id);
	if(count($pln) > 0){
		$sdate = reverseDate($pln[0]['plan_start_date']);
		$edate = reverseDate($pln[0]['plan_end_date']);
		$vac = $sql->query("SELECT a.*, b.`vacation_type_title`, c.`staff_fullname` FROM `staff_vacations` a, `vacation_types` b, `staff` c WHERE `vacation_status` > ".$st." AND `vacation_startdate` >= '".$sdate."' AND `vacation_startdate` <= '".$edate."'".$flgCnd." AND b.`vacation_type_id` = a.`vacation_type_id` AND c.`staff_id` = a.`staff_id` ORDER BY `vacation_status` ASC, `vacation_startdate` DESC");
		if(count($vac) > 0){
			return $vac;
		}
	}
	return false;
}

function monthVacs($mid){
	$sql  = $GLOBALS['sql'];	
	$days = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$mid);
	$msd  = $days[0]['day_date'];
	$med  = $days[29]['day_date'];
	
	$vac = $sql->query("SELECT a.*, b.`vacation_type_title`, c.`staff_fullname` FROM `staff_vacations` a, `vacation_types` b, `staff` c WHERE `vacation_status` >= 2 AND b.`vacation_type_id` = a.`vacation_type_id` AND c.`staff_id` = a.`staff_id` ORDER BY `vacation_status` ASC, `vacation_startdate` ASC");
	
	$out = array();
	foreach($vac as $v){
		$vds = vacDaysA($v['vacation_id']);
		if(in_array($msd, $vds) || in_array($med, $vds) || ($v['vacation_startdate'] >= $msd && $v['vacation_startdate'] <= $med)){
			$out[] = $v;
		}
	}
	
	if(count($out) > 0){
		return $out;
	}
	
	return false;
}

function archiveVacs(){
	$sql  = $GLOBALS['sql'];		
	
	$vac = $sql->query("SELECT a.*, b.`vacation_type_title`, c.`staff_fullname` FROM `staff_vacations` a, `vacation_types` b, `staff` c WHERE `vacation_status` = -2 AND b.`vacation_type_id` = a.`vacation_type_id` AND c.`staff_id` = a.`staff_id` ORDER BY `vacation_id` ASC");
	
	if(count($vac) > 0) return $vac;
	
	return false;
}

function staffVacCut($plan_id, $st = -1, $id = NULL, $flag = NULL){
	$sql = $GLOBALS['sql'];
	$flags = array("d", "s");
	if(intval($id) > 0 && in_array($flag, $flags)){
		switch($flag){
			case 'd':
				$flgCnd = " AND c.`staff_id` IN ( SELECT `staff_id` FROM `dept_staff` WHERE `dept_id` = ".intval($id)." ) ";
			break;
			case 's':
				$flgCnd = " AND c.`staff_id` = ".intval($id);
			break;
		}
	}else $flgCnd = "";
	
	$flgCnd .= " AND a.`vacation_type_id` IN ( SELECT `vacation_type_id` FROM `vacation_types` WHERE `vacation_type_need_cut` = 1 )";
	
	$pln = $sql->query("SELECT * FROM `plans` WHERE `plan_id` = ".$plan_id);
	if(count($pln) > 0){
		$sdate = reverseDate($pln[0]['plan_start_date']);
		$edate = reverseDate($pln[0]['plan_end_date']);
		$vac = $sql->query("SELECT a.*, b.`vacation_type_title`, c.`staff_fullname` FROM `staff_vacations` a, `vacation_types` b, `staff` c WHERE `vacation_status` > ".$st." AND `vacation_startdate` >= '".$sdate."' AND `vacation_startdate` <= '".$edate."'".$flgCnd." AND b.`vacation_type_id` = a.`vacation_type_id` AND c.`staff_id` = a.`staff_id` ORDER BY `vacation_status` ASC, `vacation_startdate` DESC");
		if(count($vac) > 0){
			return $vac;
		}
	}
	return false;
}

function getVac($vac_id){
	$sql = $GLOBALS['sql'];
	$vac = $sql->query("SELECT * FROM `staff_vacations` WHERE `vacation_id` = ".$vac_id);
	if(count($vac) > 0) return $vac[0];
	return false;
}

function deleteVac($id){
	$sql = $GLOBALS['sql'];
	setStaffVacDays($id, 0);
	if(toArchive("staff_vacations", "vacation_id", $id)){
		if($sql->simple("DELETE FROM `staff_vacations` WHERE `vacation_id` = ".$id)){
			return true;
		}
	}
	return false;
}

function saveVac(array $arr, $id = NULL){
	$sql = $GLOBALS['sql'];	
	$cnd = array();
	
	foreach($arr as $fld => $vlu){
		if($fld == "vacation_startdate"){
			$date = sysDate($vlu);
			$vlu  = $date[8] == "H" ? aDate($date) : $date;
		}
		
		if($fld == "vacation_cut_date"){
			$date = sysDate($vlu);
			$vlu  = $date[8] == "H" ? aDate($date) : $date;
		}
		
		if($fld == "vacation_balance" && $vlu == 0){
			$pln = getPlan();
			$vlu = staffBalance($arr['staff_id'], $pln['plan_id']);
		}
		
		if($fld == "vacation_status" && $vlu < 0){
			
			$forCCP = false;
			
			if(Fld("vacation_types", "vacation_type_id", $arr['vacation_type_id'], "vacation_type_status") < 1) $forCCP = true;
			
			$rolls = getStaffRolls($arr['staff_id']);
			
			if(canSeePage('ccp', $rolls)){
				$vlu = 2;
			}elseif(canSeePage('dcp', $rolls) || $forCCP){
				$vlu = 1;
			}else{
				$vlu = 0;
			}
		}
		
		$cnd[] = "`".$fld."` = '".$vlu."'";
	}
	
	$str = implode(", ", $cnd);
	
	if(intval($id) > 0){
		$txt = "UPDATE `staff_vacations` SET ".$str." WHERE `vacation_id` = ".intval($id);
	}else{
		$txt = "INSERT INTO `staff_vacations` SET ".$str;
	}
	
	if($sql->simple($txt)){
		$vac_id = intval($id) > 0 ? intval($id) : $sql->insertedId();
		setStaffVacDays($vac_id, 4);
		return true;
	}
	
	return false;
}

function setStaffVacDays($vac_id, $st = 0){
	$sql = $GLOBALS['sql'];
	$vac = $sql->query("SELECT * FROM `staff_vacations` WHERE `vacation_id` = ".$vac_id." AND `vacation_status` >= 2");
	if(count($vac) > 0){
		extract($vac[0]);
		for($i = 0; $i < $vacation_duration; $i++){
			$dayDate = datePlusDays($vacation_startdate, $i);
			
			$sql->simple("UPDATE `staff_timesheet` SET `status` = '0' WHERE `day_id` = ( SELECT `day_id` FROM `plan_month_days` WHERE `day_date` = '".$dayDate."' ) AND `staff_id` = ".$staff_id);
			
			if($st > 0) $sql->simple("UPDATE `staff_timesheet` SET `status` = '".$st."' WHERE `day_id` = ( SELECT `day_id` FROM `plan_month_days` WHERE `day_date` = '".$dayDate."' ) AND `staff_id` = ".$staff_id);
		}
		return true;
	}
	return false;
}
?>