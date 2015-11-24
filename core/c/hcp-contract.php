<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
require_once($rootPath."core/m/vacations.php");
require_once($rootPath."core/m/contracts.php");
if(canSeePage('hcp', $_SESSION['staff']['rolls'])){
	if(isset($_GET['contract_id']) && intval($_GET['contract_id']) > 0){	
		$contract_id = intval($_GET['contract_id']);
		$contract    = getContracts($contract_id);
		include($rootPath."core/v/header.php");
		if(isset($_GET['act'])){
			switch($_GET['act']){
				case 'edit':
					include($rootPath."core/v/hcp/contracts/edit.php");	
				break;
				case 'delete':
					include($rootPath."core/v/hcp/contracts/view.php");
					if(deleteAll("staff_contracts", "contract_id", $contract_id)) Redir("index.php?c=hcp-contracts");
				break;
				case 'view':
				default:
					include($rootPath."core/v/hcp/contracts/view.php");	
				break;
			}
		}else{
			include($rootPath."core/v/hcp/contracts/view.php");	
		}
		include($rootPath."core/v/footer.php");
	}else{
		include($rootPath."core/v/header.php");
		$dts = array("contract_date", "renew_date", "ending_date");
		$txt = array("contract_details");
		if(isset($_POST['act']) && $_POST['act'] == "save"){
			$arr = array();
			foreach($_POST['v'] as $fld => $vlu){
				if(in_array($fld, $dts)) $arr[$fld] = sysDate($vlu);
				elseif(in_array($fld, $txt)) $arr[$fld] = htmlentities($vlu, ENT_QUOTES);
				else $arr[$fld] = $vlu;
			}
			foreach($_FILES as $n => $v){
				$upFile  = upload($n, "contracts", "work");
				if($upFile != "") $arr[$n] = $upFile;
			}
			saveAll($_POST['tbl'], $arr, $_POST['idf'], $_POST['id']);
			Redir("index.php?c=hcp-contracts");
		}else{
			$staff = staffList("WHERE `staff_id` NOT IN ( SELECT `staff_id` FROM `staff_contracts` WHERE `contract_id` NOT IN ( SELECT `contrcat_id` FROM `staff_contract_ending` ) )");
			if(count($staff) > 0) include($rootPath."core/v/hcp/contracts/add.php");
			else Redir("index.php?c=hcp-contracts");
		}
		include($rootPath."core/v/footer.php");
	}
}else{
	include($rootPath."core/v/banned.php");
}
?>