<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");

if(isset($_GET['staff_id']) && intval($_GET['staff_id']) > 0){
	$staff_id = intval($_GET['staff_id']);
	if(intval( $_SESSION['staff']['staff_id'] ) == intval( $_GET['staff_id'] ) || ( canSeePage( 'acp', $_SESSION['staff']['rolls'] ) || canSeePage( 'ccp', $_SESSION['staff']['rolls'] ) || canSeePage( 'hcp', $_SESSION['staff']['rolls'] ) ) ){
		$seeAllData = true;
	}else{
		$seeAllData = false;	
	}
}elseif(isset($_SESSION['staff']['staff_id']) && intval($_SESSION['staff']['staff_id']) > 0){
	$staff_id = intval($_SESSION['staff']['staff_id']);
	$seeAllData = true;
}else{
	include($rootPath."core/v/banned.php");
	die();	
}

$staff = getFullStaff($staff_id);

$pln   = datePlan($tda);
$svb   = staffBalance($staff_id, $pln['plan_id']);
$svb   = $svb > 60 ? 60 : $svb;

include($rootPath."core/v/header.php");

if(isset($_GET['c']) && $_GET['c'] == "profile"){
	
	include($rootPath."core/v/profile/header.php");
	include($rootPath."core/v/profile/basic.php");
	
	if($seeAllData === true){
		if(isset($_REQUEST['mod']) && $_REQUEST['mod'] == "family"){
			if(isset($_POST['act'])){
				switch($_POST['act']){
					case 'edit':
						extract($_POST);
						if(editFamily($id, $fullname, $relationship, $country_id, $comming_type, $comming_date, $birthdate, $ssid, $ssid_ex_date)) Redir("index.php?c=profile&staff_id=".$staff_id."#family");
					break;
					case 'add':
						extract($_POST);
						if(addFamily($staff_id, $fullname, $relationship, $country_id, $comming_type, $comming_date, $birthdate, $ssid, $ssid_ex_date)) Redir("index.php?c=profile&staff_id=".$staff_id."#family");
					break;
				}
			}
			
			if(isset($_GET['delete']) && intval($_GET['delete']) > 0){
				if(deleteFamily(intval($_GET['delete']))) Redir("index.php?c=profile&staff_id=".$staff_id."#family");
			}
		}
		
		$family = getStaffFamily($staff_id);
		$countries = countryList();
		include($rootPath."core/v/profile/family.php");
		
		if(isset($_REQUEST['mod']) && $_REQUEST['mod'] == "docs"){
			if(isset($_POST['act'])){
				switch($_POST['act']){
					case 'edit':
						extract($_POST);
						if(editDoc($id, $type, $sdate, $edate, $title, $details)) Redir("index.php?c=profile&staff_id=".$staff_id."#docs");
					break;
					case 'add':
						extract($_POST);
						if(addDoc($staff_id, $type, $sdate, $edate, $title, $details)) Redir("index.php?c=profile&staff_id=".$staff_id."#docs");
					break;
				}
			}
			
			if(isset($_GET['delete']) && intval($_GET['delete']) > 0){
				if(deleteDoc(intval($_GET['delete']))) Redir("index.php?c=profile&staff_id=".$staff_id."#family");
			}
		}
		
		$docs = getStaffDocs($staff_id);
		include($rootPath."core/v/profile/docs.php");
	}
	
	include($rootPath."core/v/profile/footer.php");
}else{
	include($rootPath."core/v/logo.php");
}
include($rootPath."core/v/footer.php");
?>