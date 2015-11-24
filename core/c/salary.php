<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");

$mid = dateMonth(date("Ymd")."A");
$mmm = getMonth($mid);
$sid = $_SESSION['staff']['staff_id'];
$sms = staffMoneySheet($sid, $mid);

if(!isset($_SESSION['my_data']) || in_array($_SESSION['my_data']['staff_id'], array(101, 105, 107, 128))){
	if($sms['last_update'] > 0){
		
		$int = $sms['basic'] + $sms['badal_transport'] + $sms['badal_housing'] + $sms['badal_worknature'] + $sms['badal_entedab'] + $sms['badal_takleef'] + $sms['badal_communication'] + $sms['extras'] + $sms['awards'] + $sms['iso'];
		$out = $sms['delays'] + $sms['loans'] + $sms['discounts'] + $sms['isp'] + $sms['iso'];
		$tot = $int - $out;
		
		include($rootPath."core/v/header.php");
		include($rootPath."core/v/scp/salary.php");
		include($rootPath."core/v/footer.php");
	}else RedirWM("index.php", "لم يعتمد المسير الخاص بك لشهر ".$mmm['ar_month_name']." حتى الآن");
}else RedirWM("index.php", "بيانات سرية لا يمكنك الإطلاع عليها");
?>