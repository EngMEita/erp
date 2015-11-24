<?php
require_once($rootPath."core/m/global.php");
if(isset($_GET['dt']) && $_GET['dt'] != ""){
	$dt = sysDate($_GET['dt']);
	$rd = reverseDate($dt);
	$dy = Fld("week_days", "week_day_id", dayOfDate($dt), "week_day_name");
	echo "( ".$dy." ".formatDate($rd, "dd-mm-yyyy T")." )";
}
?>