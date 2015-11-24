<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/plans.php");
require_once($rootPath."core/m/vacations.php");
if(canSeePage('hcp', $_SESSION['staff']['rolls'])){
	
	if(isset($_POST['act']) && $_POST['act'] == "save"){
		extract($_POST);
		$vac_id = isset($id) && intval($id) > 0 ? intval($id) : NULL;
		if(saveVacation($vac, $vac_id)) Redir("index.php?c=hcp-vacations");
	}
	
	if(isset($_GET['delete']) && intval($_GET['delete']) > 0){
		if(deleteVacation(intval($_GET['delete']))) Redir("index.php?c=hcp-vacations");
	}
	
	$vac = getVacations();
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/hcp/vacations.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>