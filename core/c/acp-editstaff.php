<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
if(isset($_GET['staff_id']) && intval($_GET['staff_id']) > 0 && ( canSeePage('acp', $_SESSION['staff']['rolls']) || canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) )){
	$staff_id = intval($_GET['staff_id']);
	$b1 = $b2 = "index.php?c=acp-staff";
}elseif(isset($_SESSION['staff']['staff_id'])){
	$staff_id = intval($_SESSION['staff']['staff_id']);
	$b1 = "index.php?a=logout";
	$b2 = "index.php?c=profile";
}else{
	include($rootPath."core/v/banned.php");
	die();
}
	
$staff = getFullStaff($staff_id);

if(isset($_POST['act'])){
	foreach($_POST as $n => $v){
		$$n = $v;
		if(in_array($n, array("bd", "ex"))){
			$$n = sysDate($v);
		}
	}
	
	foreach($_FILES as $n => $v){
		$$n = upload($n, "uploads", "images");
	}
	
	switch($_POST['act']){
		case 'editStaffLogin':
			if(editStaffLogin($un, $pw, $mn, $ue, $staff_id)) Redir($b1);
		break;
		case 'editStaffPersonal':
			if(editStaffPersonal($fn, $sn, $pi, $s, $bd, $id, $ex, $ii, $ki, $ci, $ad, $staff_id)) Redir($b2);
		break;
	}
}

$kafeel = kafeelList();
$countries = countryList();

include($rootPath."core/v/header.php");
include($rootPath."core/v/acp/staff/edit.php");
include($rootPath."core/v/footer.php");
?>