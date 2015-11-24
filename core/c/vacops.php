<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
require_once($rootPath."core/m/vacations.php");
$plan = datePlan($tda);
$ops = array("add", "edit", "delete", "print", "status", "save");
if(isset($_GET['op']) && in_array($_GET['op'], $ops)){
	$op = $_GET['op'];
	switch($op){
		case 'save';
			if(isset($_POST)){
				extract($_POST);
				foreach($_FILES as $n => $x){
					$v[$n] = upload($n, "vacs", "work");
				}
				if(saveVac($v, $vac_id)) Redir("index.php?c=hcp-staffvacations");
				include($rootPath."core/v/banned.php");
			}
		break;
		case 'add':
			if(isset($_GET['vacation_type_id']) && intval($_GET['vacation_type_id']) > 0){
				$vacation_type_id = intval($_GET['vacation_type_id']);
				$vacation_type    = getVacation($vacation_type_id);
				if(canSeePage('hcp', $_SESSION['staff']['rolls'])){
					$staff    = staffList();
				}else{
					$staff_id = $_SESSION['staff']['staff_id'];
				}
				include($rootPath."core/v/header.php");
				include($rootPath."core/v/hcp/vac/add.php");
				include($rootPath."core/v/footer.php");
			}else{
				include($rootPath."core/v/banned.php");
			}
		break;
		case 'edit':
			if(isset($_GET['vac_id']) && intval($_GET['vac_id']) > 0){
				$vac              = getVac(intval($_GET['vac_id']));
				$vacation_type_id = $vac['vacation_type_id'];
				$vacation_type    = getVacation($vacation_type_id);
				include($rootPath."core/v/header.php");
				include($rootPath."core/v/hcp/vac/edit.php");
				include($rootPath."core/v/footer.php");
			}else{
				include($rootPath."core/v/banned.php");
			}
		break;
		case 'delete':
			if(isset($_GET['vac_id']) && intval($_GET['vac_id']) > 0){
				if(deleteVac(intval($_GET['vac_id'])))  Redir("index.php?c=hcp-staffvacations");
			}
			include($rootPath."core/v/banned.php");
		break;
		case 'print':
			if(isset($_GET['vac_id']) && intval($_GET['vac_id']) > 0){
				$vac              = getVac(intval($_GET['vac_id']));
				$vacation_type_id = $vac['vacation_type_id'];
				$vacation_type    = getVacation($vacation_type_id);
				$last_vac         = staffLastVac($vac['staff_id'], 1);
				$staff            = getFullStaff($vac['staff_id']);
				include($rootPath."core/v/hcp/vac/print.php");
				if(canSeePage('hcp', $_SESSION['staff']['rolls'])){
					$arr['vacation_hr_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time().":3";
					$arr['vacation_status']  = 3;
					saveVac($arr, intval($_GET['vac_id']));
				}elseif(canSeePage('ccp', $_SESSION['staff']['rolls'])){
					$arr['vacation_ce_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time().":3";
					$arr['vacation_status']  = 3;
					saveVac($arr, intval($_GET['vac_id']));
				}
			}else{
				include($rootPath."core/v/banned.php");
			}
		break;
		case 'status':
			if(isset($_GET['status'], $_GET['vac_id']) && intval($_GET['vac_id']) >= 0){
				$arr = array();
				if(canSeePage('ccp', $_SESSION['staff']['rolls'])){
					$arr['vacation_ce_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time().":".intval($_GET['status']);
					$c = "ccp";
					$cntu = true;
				}elseif(canSeePage('hcp', $_SESSION['staff']['rolls'])){
					$arr['vacation_hr_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time().":".intval($_GET['status']);
					$c = "hcp";
					$cntu = true;
				}elseif(canSeePage('dcp', $_SESSION['staff']['rolls'])){
					$arr['vacation_dm_hash'] = $_SESSION['staff']['staff_id'].":".$tdh.":".time().":".intval($_GET['status']);
					$c = "dcp";
					$cntu = true;
				}else{
					$cntu = false;
				}
				if($cntu){
					$arr['vacation_status'] = intval($_GET['status']);
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