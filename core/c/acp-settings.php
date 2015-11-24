<?php
require_once($rootPath."core/m/global.php");
if(canSeePage('acp', $_SESSION['staff']['rolls'])){
	$gs_titles = array('org_title' => "عنوان البرنامج", 'org_email' => "بريد البرنامج", 'org_mobile' => "جوال البرنامج", 'org_recordsperpage' => "عدد السجلات بالصفحة", 'org_monthlyleaves' => "الأذونات الشهرية المسموح بيها", 'org_maxvacationsbalanc' => "رصيد الأجازات الأقصى المسموح بيه");
	if(isset($_POST['act']) && $_POST['act'] == "save"){
		$q = array();
		foreach($gs as $name => $value){
			if(isset($_POST[$name]) && $_POST[$name] != $value){
				$q[] = "`".$name."` = '".$_POST[$name]."'";
			}
		}
		$qs = implode(", ", $q);
		if($sql->simple("UPDATE `general_settings` SET ".$qs." WHERE `id` = 321456")) $ntf = "تم تحديث الإعدادات بنجاح!";
	}
	$gs = getSettings();
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/acp/gsettings.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>