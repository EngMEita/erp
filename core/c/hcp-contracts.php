<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
require_once($rootPath."core/m/vacations.php");
require_once($rootPath."core/m/contracts.php");
if(canSeePage('hcp', $_SESSION['staff']['rolls'])){
	
	$cntrs = getContracts();
		
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/hcp/contracts/list.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>