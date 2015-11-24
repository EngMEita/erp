<?php
function getFullStaff($id){
	$out = array();
	$sql = $GLOBALS['sql'];
	$ss  = $sql->query("SELECT a.*, b.`kafeel_name`, b.`kafeel_out`, c.`country_nationality` FROM `staff` a, `kafeel` b, `countries` c WHERE a.`staff_id` = ".intval($id)." AND b.`kafeel_id` = a.`staff_kafeel_id` AND c.`country_id` = a.`staff_country_id` LIMIT 1");
	$i = 0;
	foreach($ss as $k => $v){
		if($v['kafeel_out'] > 0){
			$ss[$k]['kafala'] = "كفالة خارجية";
		}elseif($v['kafeel_out'] < 0){
			$ss[$k]['kafala'] = "";
		}else{
			$ss[$k]['kafala'] = "كفالة داخلية";
		}	
	}
	foreach($ss as $s){
		$out[$i]  = array();
		
		$contract = $sql->query("SELECT `contract_id`, `contract_date`, `contract_test_duration`, `contract_duration`, `contract_renewable`, `contract_type` FROM `staff_contracts` WHERE `staff_id` = ".$s['staff_id']." ORDER BY `contract_date` DESC, `contract_id` DESC LIMIT 1");
		
		$dept = $sql->query("SELECT a.`dept_id`, a.`job_code`, a.`job_title`, a.`dept_joindate`, b.`dept_name`, c.`work_pos_title`, c.`work_pos_rank` FROM `dept_staff` a, `depts` b, `work_pos` c WHERE a.`staff_id` = ".$s['staff_id']." AND a.`status` = 1 AND b.`dept_id` = a.`dept_id` AND c.`work_pos_id` = a.`work_pos_id` ORDER BY a.`dept_joindate` DESC LIMIT 1");
		
		foreach($s as $n => $v){
			$out[$i][$n] = $v;
			if($n == "staff_birthdate" || $n == "staff_ssid_exdate"){		
				$out[$i][$n."_short"] = formatDate($v, "yyyy-mm-dd");
				$out[$i][$n."_full"] = formatDate($v, "dd MM yyyy T");
			}
			
			if($n == "staff_birthdate"){
				$age = ageCalc($v);
				$out[$i]['staff_age'] = $age['r_age'];
			}
			if($n == "staff_ssid_exdate"){
				$age = ageCalc($v);
				$out[$i]['ssid_months'] = $age['in_months'];
			}
		}
		
		if(isset($contract[0]) && is_array($contract[0])){
			foreach($contract[0] as $n => $v){
				$out[$i][$n] = $v;
				if($n == "contract_date"){
					$age = ageCalc($v);
					$out[$i]['service_duration'] = $age;
				}
			}
		}
		
		if(isset($dept[0]) && is_array($dept[0])){
			foreach($dept[0] as $n => $v){
				$out[$i][$n] = $v;
			}
		}
		
		$out[$i]['rolls'] = implode(", ", getStaffRolls($s['staff_id']));
		$out[$i]['staff_rolls'] = getStaffRolls($s['staff_id']);
		
		$i++;
	}
	return $out;
}

function staffList($cond = NULL){
	$sql = $GLOBALS['sql'];
	if(!is_null($cond)) $cond .= " AND `staff_username` NOT LIKE 'deleted_%'";
	else $cond = " WHERE `staff_username` NOT LIKE 'deleted_%'";
	$out = $sql->query("SELECT `staff_id`, `staff_fullname` FROM `staff` ".$cond." ORDER BY `staff_fullname` ASC");
	return $out;
}

function getStaff($id = NULL){
	$out = array();
	$sql = $GLOBALS['sql'];
	$tdh = $GLOBALS['tdh'];
	if(is_null($id) || intval($id) === 0){
		$ss  = $sql->query("SELECT a.`staff_id`, a.`staff_mobile`, a.`staff_email`, a.`staff_fullname`, a.`staff_shortname`, a.`staff_username`, a.`staff_birthdate`, a.`staff_gender`, a.`staff_ssid`, a.`staff_ssid_exdate`, b.`kafeel_name`, b.`kafeel_out`, c.`country_nationality` FROM `staff` a, `kafeel` b, `countries` c WHERE a.`staff_username` NOT LIKE 'deleted_%' AND b.`kafeel_id` = a.`staff_kafeel_id` AND c.`country_id` = a.`staff_country_id`");
	}else{
		$ss  = $sql->query("SELECT a.`staff_id`, a.`staff_mobile`, a.`staff_fullname`, a.`staff_shortname`, a.`staff_username`, a.`staff_birthdate`, a.`staff_gender`, a.`staff_ssid`, a.`staff_ssid_exdate`, b.`kafeel_name`, b.`kafeel_out`, c.`country_nationality` FROM `staff` a, `kafeel` b, `countries` c WHERE a.`staff_id` = ".intval($id)." AND b.`kafeel_id` = a.`staff_kafeel_id` AND c.`country_id` = a.`staff_country_id` LIMIT 1");
	}
	
	foreach($ss as $k => $v){
		if($v['kafeel_out'] > 0){
			$ss[$k]['kafala'] = "خارجية";
		}elseif($v['kafeel_out'] < 0){
			$ss[$k]['kafala'] = "";
		}else{
			$ss[$k]['kafala'] = "داخلية";
		}	
	}
	
	$i = 0;
	foreach($ss as $s){
		$out[$i]  = array();
		
		$contract = $sql->query("SELECT `contract_id`, `contract_date`, `contract_test_duration`, `contract_duration`, `contract_renewable`, `contract_type` FROM `staff_contracts` WHERE `staff_id` = ".$s['staff_id']." ORDER BY `contract_date` DESC, `contract_id` DESC LIMIT 1");
		
		$dept = $sql->query("SELECT a.`dept_id`, a.`job_code`, a.`job_title`, a.`dept_joindate`, b.`dept_name`, c.`work_pos_title`, c.`work_pos_rank` FROM `dept_staff` a, `depts` b, `work_pos` c WHERE a.`staff_id` = ".$s['staff_id']." AND a.`status` = 1 AND b.`dept_id` = a.`dept_id` AND c.`work_pos_id` = a.`work_pos_id` ORDER BY a.`dept_joindate` DESC LIMIT 1");
		
		foreach($s as $n => $v){
			$out[$i][$n] = $v;
			if($n == "staff_birthdate"){
				$age = ageCalc($v);
				$out[$i]['staff_age'] = $age['r_age'];
			}
			
			if($n == "staff_ssid_exdate"){
				$exp = ageCalc($v);
				$out[$i]['ssid_days'] = $exp['in_days'];
			}
			
			if($n == "staff_birthdate" || $n == "staff_ssid_exdate"){		
				$out[$i][str_replace("staff_", "", $n)] = formatDate($v, "yyyy-mm-dd");
			}
		}
		
		if(isset($contract[0]) && is_array($contract[0])){
			foreach($contract[0] as $n => $v){
				$out[$i][$n] = $v;
			}
		}
		
		if(isset($dept[0]) && is_array($dept[0])){
			foreach($dept[0] as $n => $v){
				$out[$i][$n] = $v;
			}
		}
		
		$out[$i]['rolls'] = implode(", ", getStaffRolls($s['staff_id']));
		$out[$i]['staff_rolls'] = getStaffRolls($s['staff_id']);
		
		$i++;
	}
	return $out;
}

function searchStaff($q){
	$sql  = $GLOBALS['sql'];
	$prts = explode(", ",$q);
	$out  = array();
	foreach($prts as $p){
		$n = str_replace(" ", "%", $p);
		$staff = $sql->query("SELECT `staff_id`, `staff_fullname`, `staff_shortname` FROM `staff` WHERE `staff_fullname` LIKE '%".$n."%' OR `staff_shortname` LIKE '%".$n."%'");
		foreach($staff as $s){
			$out[] = $s;
		}
	}
	return $out;
}

function addStaff($un, $pw, $mn, $ue, $fn, $sn, $pi, $s, $bd, $id, $ex, $ii, $ki, $ci, $ad){
	$sql = $GLOBALS['sql'];
	if($sql->simple("INSERT INTO `staff` VALUES( '', '".$un."', '".md5(md5($pw))."', '".$mn."', '".$ue."', '".$fn."', '".$sn."', '".$pi."', '".$s."', '".$bd."', '".$id."', '".$ex."', '".$ii."', '".$ki."', '".$ci."', '".$ad."')")){
		 $st_id = $sql->insertedId();
		 $sql->simple("INSERT INTO `staff_rolls` SET `staff_id` = ".$st_id.", `roll` = 'scp'");
		 return true;
	}
	return false;
}

function editStaffLogin($un, $pw, $mn, $ue, $staff){
	$sql = $GLOBALS['sql'];
	$txt = $pw != "" ? ", `staff_password` = '".md5(md5($pw))."'" : "";
	if($sql->simple("UPDATE `staff` SET `staff_username` = '".$un."'".$txt.", `staff_mobile` = '".$mn."', `staff_email` = '".$ue."' WHERE `staff_id` = ".$staff)) return true;
	return false;
}

function editStaffPersonal($fn, $sn, $pi, $s, $bd, $id, $ex, $ii, $ki, $ci, $ad, $staff){
	$sql = $GLOBALS['sql'];
	$img1 = $pi != "" ? ", `staff_image` = '".$pi."'" : "";
	$img2 = $ii != "" ? ", `staff_ssid_image` = '".$ii."'" : "";
	if($sql->simple("UPDATE `staff` SET `staff_fullname` = '".$fn."', `staff_shortname` = '".$sn."'".$img1.", `staff_gender` = '".$s."', `staff_birthdate` = '".$bd."', `staff_ssid` = '".$id."', `staff_ssid_exdate` = '".$ex."'".$img2.", `staff_kafeel_id` = '".$ki."', `staff_country_id` = '".$ci."', `staff_address` = '".$ad."' WHERE `staff_id` = ".$staff)) return true;
	return false;
}

function deleteStaff($id){
	$sql = $GLOBALS['sql'];
	if(toArchive("staff", "staff_id", $id)){
		if($sql->simple("UPDATE `staff` SET `staff_username` = CONCAT('deleted_', `staff_username`) WHERE `staff_id` = ".$id)) return true;
	}
	return false;
}

function kafeelList(){
	$sql = $GLOBALS['sql'];
	$list = $sql->query("SELECT * FROM `kafeel` ORDER BY `kafeel_out` ASC, `kafeel_name` ASC");
	return $list;
}

function countryList(){
	$sql = $GLOBALS['sql'];
	$list = $sql->query("SELECT * FROM `countries` ORDER BY `country_id` ASC");
	return $list;
}

function getStaffFamily($id){
	$sql = $GLOBALS['sql'];
	$out = $sql->query("SELECT * FROM `staff_family` WHERE `staff_id` = ".$id." ORDER BY `comming_date` ASC, `birthdate` ASC");
	return $out;
}

function addFamily($staff, $fullname, $relationship, $country, $comming_type, $comming_date, $birthdate, $ssid, $ssid_exdate){
	$sql = $GLOBALS['sql'];
	list($g, $r) = explode(".", $relationship);
	
	if($sql->simple("INSERT INTO `staff_family` VALUES( '', ".$staff.", '".$fullname."', ".$r.", ".$g.", ".$country.", '".sysDate($comming_date)."', ".$comming_type.", '".sysDate($birthdate)."', '".$ssid."', '".sysDate($ssid_exdate)."', '' )")) return true;
	return false;
}

function editFamily($id, $fullname, $relationship, $country, $comming_type, $comming_date, $birthdate, $ssid, $ssid_exdate){
	$sql = $GLOBALS['sql'];
	list($g, $r) = explode(".", $relationship);
	
	if($sql->simple("UPDATE `staff_family` SET `fullname` = '".$fullname."', `relationship` = ".$r.", `gender` = ".$g.", `country_id` = ".$country.", `comming_date` = '".sysDate($comming_date)."', `comming_type` = ".$comming_type.", `birthdate` = '".sysDate($birthdate)."', `ssid` = '".$ssid."', `ssid_ex_date` = '".sysDate($ssid_exdate)."' WHERE `id` = ".$id)) return true;
	return false;
}

function deleteFamily($id){
	$sql = $GLOBALS['sql'];
	
	if($sql->simple("DELETE FROM `staff_family` WHERE `id` = ".$id)) return true;
	return false;
}

function familyRelation($r, $s){
	switch($r){
		case 0:
			$out = $s > 0 ? "زوجة" : "زوج";
		break;
		case 1:
			$out = $s > 0 ? "ابنة" : "ابن";
		break;
		case 2:
			$out = $s > 0 ? "أم" : "أب";
		break;
	}
	return $out;
}

function familyComming($c){
	switch($c){
		case 0:
			$out = "مواليد المملكة";
		break;
		case 1:
			$out = "سعودي الجنسية";
		break;
		case 2:
			$out = "إقامة";
		break;
		case 3:
			$out = "زيارة";
		break;
	}
	return $out;
}

function getStaffDocs($id){
	$sql = $GLOBALS['sql'];
	$out = $sql->query("SELECT * FROM `staff_docs` WHERE `staff_id` = ".$id);
	return $out;
}

function addDoc($staff, $type, $sdate, $edate, $title, $details){
	$sql = $GLOBALS['sql'];
	
	if($sql->simple("INSERT INTO `staff_docs` VALUES( '', ".$staff.", ".$type.", '".sysDate($sdate)."', '".sysDate($edate)."', '".$title."', '".$details."', '' )")) return true;
	return false;
}

function editDoc($id, $type, $sdate, $edate, $title, $details){
	$sql = $GLOBALS['sql'];
	
	if($sql->simple("UPDATE `staff_docs` SET `doc_type` = ".$type.", `doc_start_date` = '".sysDate($sdate)."', `doc_end_date` = '".sysDate($edate)."', `doc_title` = '".$title."', `doc_details` = '".$details."' WHERE `doc_id` = ".$id )) return true;
	return false;
}

function deleteDoc($id){
	$sql = $GLOBALS['sql'];
	
	if($sql->simple("DELETE FROM `staff_docs` WHERE `doc_id` = ".$id)) return true;
	return false;
}

function docType($t){
	switch($t){
		case 0:
			$out = "وثيقة شخصية";
		break;
		case 1:
			$out = "شهادة خبرة";
		break;
		case 2:
			$out = "وثيقة رسمية";
		break;
		case 3:
			$out = "وثيقة علمية";
		break;
	}
	return $out;
}
require_once("plans.php");
require_once("vacations.php");
?>