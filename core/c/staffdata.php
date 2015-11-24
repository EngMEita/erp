<?php
require_once($rootPath."core/m/global.php");
if(isset($_GET['fld'], $_GET['id']) && $_GET['fld'] != "" && intval($_GET['id']) > 0){
	echo Fld("staff", "staff_id", intval($_GET['id']), $_GET['fld']);
}
?>