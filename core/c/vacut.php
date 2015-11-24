<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
require_once($rootPath."core/m/vacations.php");
$plan = getPlan();
$ops = array("cut", "status", "save");
if(isset($_GET['op']) && in_array($_GET['op'], $ops)){
	$op = $_GET['op'];
}else{
	$op = "cut";
}
if(isset($_GET['vac_id']) && intval($_GET['vac_id']) > 0){	
	$vac_id = intval($_GET['vac_id']);
	switch($op){
		case 'save';
			if(isset($_POST)){
				extract($_POST);
				if(saveVac($v, $vac_id)) Redir("index.php?c=hcp-staffvacations");
				include($rootPath."core/v/banned.php");
			}
		break;
		case 'cut':
			include($rootPath."core/v/header.php");
			include($rootPath."core/v/hcp/vac/cut.php");
			include($rootPath."core/v/footer.php");
		break;
		case 'status':
			if(isset($_GET['vac_id']) && intval($_GET['vac_id']) >= 0){
				$arr = array();
				if(canSeePage('ccp', $_SESSION['staff']['rolls'])){
					$arr['vacation_cut_ce_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time();
					$c    = "ccp";
					$cntu = true;
				}elseif(canSeePage('hcp', $_SESSION['staff']['rolls'])){
					$arr['vacation_cut_hr_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time();
					$c    = "hcp";
					$cntu = true;
				}elseif(canSeePage('dcp', $_SESSION['staff']['rolls'])){
					$arr['vacation_cut_dm_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time();
					$c    = "dcp";
					$cntu = true;
				}else{
					$cntu = false;
				}
				if($cntu){
					$vac_id = intval($_GET['vac_id']);
					if(saveVac($arr, $vac_id)) Redir("index.php?c=hcp-staffvacations");
				}
				include($rootPath."core/v/banned.php");
				die();
			}		
		break;
	}
}else{
	include($rootPath."core/v/banned.php");	
}
?>