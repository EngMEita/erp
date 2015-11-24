<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");

$fld = ( isset($_GET['fld']) && $_GET['fld'] != "" ) ? $_GET['fld'] : "to";

if(isset($_GET['q']) && $_GET['q'] != ""){
	$q = $_GET['q'];
	$staff = searchStaff($q);
	include($rootPath."core/v/common/searchstaff.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>