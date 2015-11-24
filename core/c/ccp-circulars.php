<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/circulars.php");

include($rootPath."core/v/header.php");

$cir_id = ( isset($_GET['id']) && intval($_GET['id']) > 0 ) ? intval($_GET['id']) : 0;

if(isset($_GET['act']) && $_GET['act'] == "save"){
	$data = array();
	foreach($_POST as $n => $v){
		if($n == "circular_date"){
			$data[$n] = sysDate($v);
		}elseif($n != "save"){
			$data[$n] = $v;	
		}
	}
	
	foreach($_FILES as $n => $v){
		$data[$n] = upload($n, "circulars", "images");
	}
	
	if(saveCircular($data, $cir_id)) Redir("index.php?c=ccp-circulars");
}

if(isset($_GET['act']) && $_GET['act'] == "signe"){
	if(saveSigne($_POST['fld'], $_POST['vlu'], $_POST['id'])) Redir("index.php?c=ccp-circulars&id=".$cir_id);			
}

$cirs = getCirculars($cir_id);

if($cir_id == 0){
	if(isset($_GET['act']) && $_GET['act'] == "add") include($rootPath."core/v/ccp/circulars/add.php");	
	else include($rootPath."core/v/ccp/circulars/list.php");
}else{
	require_once($rootPath."core/m/staff.php");
	$s = getFullStaff($cirs[0]['staff_id']);
	if(isset($_GET['act']) && $_GET['act'] == "edit") include($rootPath."core/v/ccp/circulars/edit.php");	
	elseif(isset($_GET['act']) && $_GET['act'] == "delete"){
		deleteCircular($cir_id);
		RedirWM("index.php?c=ccp-circulars", "تم حذف التعميم رقم ".$cir_id." بنجاح.");
	}else include($rootPath."core/v/ccp/circulars/view.php");
}

include($rootPath."core/v/footer.php");
?>