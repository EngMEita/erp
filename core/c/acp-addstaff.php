<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
if(canSeePage('acp', $_SESSION['staff']['rolls']) || canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls'])){
	
	if(isset($_POST['act']) && $_POST['act'] == "addStaff"){
		foreach($_POST as $n => $v){
			$$n = $v;
			if(in_array($n, array("bd", "ex"))){
				$$n = sysDate($v);
			}
		}
		
		foreach($_FILES as $n => $v){
			$$n = upload($n, "uploads", "images");
		}
		if(addStaff($un, $pw, $mn, $ue, $fn, $sn, $pi, $s, $bd, $id, $ex, $ii, $ki, $ci, $ad)) Redir("index.php?c=acp-staff");
	}
	
	$kafeel = kafeelList();
	$countries = countryList();
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/acp/staff/add.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}

?>