<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");
if( canSeePage( 'fcp', $_SESSION['staff']['rolls'] ) && isset( $_GET['mid'] ) && intval( $_GET['mid'] ) > 0 ){
	$mid = intval( $_GET['mid'] );
	$mnt = getMonth( $mid );
	$pln = getPlan( $mid['plan_id'] );
	$msh = getMoneySheet( $mid );
	
	$cache_ext      = '.html';
	$cache_folder   = 'accounting/';
	$cache_file     = $cache_folder.$mid."_accounting".$cache_ext;
	ob_start();
	include($rootPath."core/v/fcp/moneysheet.php");
	$fp = fopen($cache_file, 'w');
    fwrite($fp, ob_get_contents());
    fclose($fp);
	ob_end_flush();
}else{
	include($rootPath."core/v/banned.php");
}
?>