<?php
require_once($rootPath."core/m/global.php");
if(isset($_GET['dt']) && $_GET['dt'] != ""){
	$dateF = ( isset($_GET['df']) && $_GET['df'] != "" ) ? sysDate($_GET['df']) : date("Ymd")."A";
	$dateT = sysDate($_GET['dt']);
	$d     = datesDif($dateF, $dateT);
	echo $d;
}else echo -1;
?>