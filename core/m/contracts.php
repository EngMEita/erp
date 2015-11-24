<?php
function saveAll($tbl, $arr, $id_fld = NULL, $id = NULL){
	$sql = $GLOBALS['sql'];
	$str = array();
	foreach($arr as $fld => $vlu){
		$str[] = "`".$fld."` = '".$vlu."'";
	}
	$str = implode(", ", $str);
	if(is_null($id) || intval($id) == 0 || is_null($id_fld) || $id_fld == "" ){
		$txt = "INSERT INTO `".$tbl."` SET ".$str;
	}else{
		$txt = "UPDATE `".$tbl."` SET ".$str." WHERE `".$id_fld."` = ".$id;
	}
	
	if($sql->simple($txt)) return true;
	return false;
}

function deleteAll($tbl, $id_fld, $id){
	$sql = $GLOBALS['sql'];
	if(toArchive($tbl, $id_fld, $id)){
		if($sql->simple("DELETE FROM `".$tbl."` WHERE `".$id_fld."` = ".$id)) return true;
	}
	return false;
}

function getContracts($id = 0){
	$sql = $GLOBALS['sql'];
	$cnd = "";
	if(intval($id) > 0) $cnd = " WHERE `contract_id` = ".intval($id);
	$c = $sql->query("SELECT * FROM `staff_contracts`".$cnd." ORDER BY `contract_date` ASC, `contract_type` ASC");
	$out = array();
	if(count($c) > 0){
		$i = 0;
		foreach($c as $r){
			$out[$i]['contract'] = $r;
			$n = $sql->query("SELECT `renew_date`, `renew_duration` FROM `staff_contract_renews` WHERE `contract_id` = ".$r['contract_id']." ORDER BY `renew_date` ASC");
			$out[$i]['renews'] = array();
			if(count($n) > 0){
				$j = 0;
				foreach($n as $w){
					$out[$i]['renews'][$j] = $w;
					$j++;
				}
			}
			$e = $sql->query("SELECT `ending_date`, `ending_type`, `get_all_benefits` FROM `staff_contract_ending` WHERE `contrcat_id` = ".$r['contract_id']." LIMIT 1");
			if(count($e) > 0) $out[$i]['ending'] = $e[0];
			else $out[$i]['ending'] = "";
			$i++;
		}
	}
	return $out;
}

function contractType($t){
	switch($t){
		case '3':
			return "عقد نساء دوام جزئي";
		break;
		case '2':
			return "عقد نساء دوام كلي";
		break;
		case '1':
			return "عقد دوام جزئي";
		break;
		case '0':
		default:
			return "عقد دوام كلي";
		break;	
	}
}

function endingType($t){
	switch($t){
		case 4:
			return "فصل بدون مكافأة";
		break;
		case 3:
			return "فصل مع المكافأة";
		break;
		case 2:
			return "تراضي الطرفين";
		break;
		case 1:
			return "إنتهاء العقد";
		break;
		case 0:
		default:
			return "إستقالة";
		break;
	}
}

function totalDuration($id){
	$c = getContracts($id);
	$tdh = $GLOBALS['tdh'];
	$jd = $c[0]['contract']['contract_date'];
	$ld = isset($c[0]['ending']['ending_date']) ? $c[0]['ending']['ending_date'] : $tdh;
	return round( datesDif( $jd, $ld ) / 360 , 2 );
}

function contractEnding($contract_id){
	$contract  = getContracts($contract_id);
	$calcDate  = isset($contract[0]['ending']['ending_date']) ? $contract[0]['ending']['ending_date'] : innerDate(date("Ymd")."A");
	$pln       = getDatePlan($calcDate);
	$stPln     = staffPlan($contract[0]['contract']['staff_id'], $pln['plan_id']);
	$salary    = $stPln['salary'];
	$total     = $stPln['salary'] + $stPln['transport'];
	$vacations = staffBalance($contract[0]['contract']['staff_id'], $pln['plan_id'], $calcDate);
	$vac_value = ( $vacations / 30 ) * $total;
	
	if($calcDate < substr($calcDate, 0, 4).'0630H'){
		$housingCalcDate = substr($calcDate, 0, 4).'0101H';	
	}else{
		$housingCalcDate = substr($calcDate, 0, 4).'0701H';
	}
	
	$housing   = round( datesDif( $housingCalcDate, $calcDate ) * $stPln['housing'] / 360, 2);
	
	$monthStartDate = substr($calcDate, 0, 6).'01H';
	$monthWorkDays  = datesDif( $monthStartDate, $calcDate );
	$staffSalary    = round( $monthWorkDays * $total / 30, 2 );
	
	if(is_array($contract[0]['ending'])){
		$dur = totalDuration($contract_id);
		if($dur > 0){
			$totalBenefits = $dur > 5 ? ( ( ( $dur - 5 ) * $salary ) + ( $salary * 5 / 2 ) ) : ( $salary * $dur / 2 );
			$rlTyps = array(0, 1, 2);
			
			if(in_array($contract[0]['ending']['ending_type'], $rlTyps)){
				if($dur > 10){
					$staffBenefits = $totalBenefits;	
				}elseif($dur > 5){
					$staffBenefits = $totalBenefits * 2 / 3;
				}elseif($dur > 2){
					$staffBenefits = $totalBenefits / 3;	
				}else{
					$staffBenefits = 0;	
				}
			}elseif($contract[0]['ending']['ending_type'] == 3){
				$staffBenefits = $totalBenefits;	
			}else{
				$staffBenefits = 0;	
			}
		}else{
			$dur = 0;
			$totalBenefits = 0;
			$staffBenefits = 0;
		}
	}else{
		$dur = 0;
		$totalBenefits = 0;
		$staffBenefits = 0;
	}
	return array("basicSalary" => $salary, "totalSalary" => $total, "monthWorkDays" => $monthWorkDays, "lastMonthSalary" => $staffSalary, "vacationsBalance" => $vacations, "vacationsValue" => round($vac_value), "serviceDuration" => round($dur, 2), "totalBenefits" => round($totalBenefits, 2), "staffBenefits" => round($staffBenefits, 2), "badalHousing" => $housing);
}
?>