<?php
require_once($rootPath."inc/config.php");

function is_staff($un, $pw){
	$out = false;
	$sql = $GLOBALS['sql'];
	$txt = "SELECT a.`staff_id`, a.`staff_mobile`, a.`staff_fullname`, a.`staff_shortname`, a.`staff_gender`, a.`staff_ssid`, b.`kafeel_name`, b.`kafeel_out`, c.`country_nationality` FROM `staff` a, `kafeel` b, `countries` c WHERE `staff_username` LIKE '".$un."' AND `staff_password` LIKE '".md5(md5($pw))."' AND b.`kafeel_id` = a.`staff_kafeel_id` AND c.`country_id` = a.`staff_country_id`";
	$s   = $sql->query($txt);
	
	if(is_array($s) && count($s) > 0){
		$out = array();
		$contract = $sql->query("SELECT `contract_id`, `contract_date`, `contract_test_duration`, `contract_duration`, `contract_renewable`, `contract_type` FROM `staff_contracts` WHERE `staff_id` = ".$s[0]['staff_id']." ORDER BY `contract_date` DESC, `contract_id` DESC LIMIT 1");
		
		if( ( count($contract) > 0 && !contract_ended($contract[0]['contract_id']) ) || count($contract) < 1 ){
			
			$dept = $sql->query("SELECT a.`dept_id`, a.`job_code`, a.`job_title`, a.`dept_joindate`, b.`dept_name`, c.`work_pos_title`, c.`work_pos_rank` FROM `dept_staff` a, `depts` b, `work_pos` c WHERE a.`staff_id` = ".$s[0]['staff_id']." AND a.`status` = 1 AND b.`dept_id` = a.`dept_id` AND c.`work_pos_id` = a.`work_pos_id` ORDER BY a.`dept_joindate` DESC LIMIT 1");
			
			if(count($dept) > 0){			
				
				foreach($s[0] as $n => $v){
					$out[$n] = $v;
				}
				foreach($contract[0] as $n => $v){
					$out[$n] = $v;
				}
				foreach($dept[0] as $n => $v){
					$out[$n] = $v;
				}
				$out['rolls'] = getStaffRolls($s[0]['staff_id']);
			}	
		}
	}
	return $out;
}

function as_staff($staff_id){
	$out = false;
	$sql = $GLOBALS['sql'];
	$txt = "SELECT a.`staff_id`, a.`staff_mobile`, a.`staff_fullname`, a.`staff_shortname`, a.`staff_gender`, a.`staff_ssid`, b.`kafeel_name`, b.`kafeel_out`, c.`country_nationality` FROM `staff` a, `kafeel` b, `countries` c WHERE `staff_id` LIKE '".$staff_id."' AND b.`kafeel_id` = a.`staff_kafeel_id` AND c.`country_id` = a.`staff_country_id`";
	$s   = $sql->query($txt);
	
	if(is_array($s) && count($s) > 0){
		$out = array();
		$contract = $sql->query("SELECT `contract_id`, `contract_date`, `contract_test_duration`, `contract_duration`, `contract_renewable`, `contract_type` FROM `staff_contracts` WHERE `staff_id` = ".$s[0]['staff_id']." ORDER BY `contract_date` DESC, `contract_id` DESC LIMIT 1");
		
		if( ( count($contract) > 0 && !contract_ended($contract[0]['contract_id']) ) || count($contract) < 1 ){
			
			$dept = $sql->query("SELECT a.`dept_id`, a.`job_code`, a.`job_title`, a.`dept_joindate`, b.`dept_name`, c.`work_pos_title`, c.`work_pos_rank` FROM `dept_staff` a, `depts` b, `work_pos` c WHERE a.`staff_id` = ".$s[0]['staff_id']." AND a.`status` = 1 AND b.`dept_id` = a.`dept_id` AND c.`work_pos_id` = a.`work_pos_id` ORDER BY a.`dept_joindate` DESC LIMIT 1");
			
			if(count($dept) > 0){			
				
				foreach($s[0] as $n => $v){
					$out[$n] = $v;
				}
				foreach($contract[0] as $n => $v){
					$out[$n] = $v;
				}
				foreach($dept[0] as $n => $v){
					$out[$n] = $v;
				}
				$out['rolls'] = getStaffRolls($s[0]['staff_id']);
			}	
		}
	}
	return $out;
}

function getStaffRolls($staff_id){
	$sql = $GLOBALS['sql'];
	//die('SELECT `roll` FROM `staff_rolls` WHERE `staff_id` = '.$staff_id.' ORDER BY `roll` ASC');
	$rolls = $sql->query('SELECT `roll` FROM `staff_rolls` WHERE `staff_id` = '.$staff_id.' ORDER BY `roll` ASC');
	$out = array();
	foreach($rolls as $r){
		$out[] = $r['roll'];
	}
	return $out;
}

function contract_ended($contract_id){
	$sql = $GLOBALS['sql'];
	$c = $sql->query("SELECT * FROM `staff_contract_ending` WHERE `contrcat_id` = ".$contract_id);
	if(count($c) > 0){
		return true;
	}
	return false;
}

function is_logged_in(){
	if(isset($_SESSION['staff'], $_SESSION['log_in_time']) && is_array( $_SESSION['staff'] ) && $_SESSION['last_activity'] > ( time() - 1800 ) ){
		$_SESSION['last_activity'] = time();
		return true;
	}else{
		if(isset($_SESSION['staff'])) unset($_SESSION['staff']);
		if(isset($_SESSION['log_in_time'])) unset($_SESSION['log_in_time']);
		$_SESSION['last_activity'] = 0;
		return false;
	}
	
}

function log_me_in($un, $pw){
	$staff = is_staff($un, $pw);
	if(is_array($staff)){
		$_SESSION['staff']			= $staff;
		$_SESSION['log_in_time']      = time();
		$_SESSION['last_activity']    = time();
		return true;
	}
	return false;
}

function log_in_as($staff_id){
	$staff = as_staff($staff_id);
	if(is_array($staff)){
		$_SESSION['my_data']          = $_SESSION['staff'];
		$_SESSION['staff']			= $staff;
		$_SESSION['log_in_time']      = time();
		$_SESSION['last_activity']    = time();
		return true;
	}
	return false;
}

function log_me_out(){
	if(isset($_SESSION['staff'])) unset($_SESSION['staff']);
	if(isset($_SESSION['my_data'])) unset($_SESSION['my_data']);
	if(isset($_SESSION['log_in_time'])) unset($_SESSION['log_in_time']);
	if(isset($_SESSION['last_activity'])) unset($_SESSION['last_activity']);
	session_destroy();
}

function log_out_as(){
	if(isset($_SESSION['my_data'])){
		unset($_SESSION['staff']);
		$_SESSION['staff']            = $_SESSION['my_data'];
		unset($_SESSION['my_data']);
		$_SESSION['log_in_time']      = time();
		$_SESSION['last_activity']    = time();
		return true;
	}else log_me_out();
}

?>