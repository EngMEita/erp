<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
if(canSeePage('acp', $_SESSION['staff']['rolls']) || canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls'])){
	
	if(isset($_GET['delete']) && intval($_GET['delete']) > 0){
		if(deleteStaff(intval($_GET['delete']))) Redir("index.php?c=acp-staff");
	}
	
	$staff = getStaff();	
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/acp/staff/list.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>