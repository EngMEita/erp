<?php
require_once($rootPath."core/m/global.php");
if(canSeePage('acp', $_SESSION['staff']['rolls'])){
	if(isset($_POST['act'])){
		switch($_POST['act']){
			case 'add':
				if($sql->simple("INSERT INTO `kafeel` VALUES ( '', '".$_POST['kafeel_name']."', '".$_POST['kafeel_out']."' )")) $ntf = "تم إضافة '".$_POST['kafeel_name']."' بنجاح.";
			break;
			case 'edit':
				if(isset($_POST['kafeel_id']) && $_POST['kafeel_id'] > 0){
					if($sql->simple("UPDATE `kafeel` SET `kafeel_name` = '".$_POST['kafeel_name']."', `kafeel_out` = '".$_POST['kafeel_out']."' WHERE `kafeel_id` = ".$_POST['kafeel_id'])) $ntf = "تم تحديث '".$_POST['kafeel_name']." [ ".$_POST['kafeel_id']." ] ' بنجاح.";
				}
			break;
		}
	}
	
	if(isset($_GET['delete']) && $_GET['delete'] > 0){
		if($sql->simple("DELETE FROM `kafeel` WHERE `kafeel_id` = ".$_GET['delete'])) Redir('index.php?c=acp-kafeel');
	}
	
	$ks = $sql->query("SELECT * FROM `kafeel`");
	foreach($ks as $k => $v){
		if($v['kafeel_out'] > 0){
			$ks[$k]['kafala'] = "نعم";
		}elseif($v['kafeel_out'] < 0){
			$ks[$k]['kafala'] = $v['kafeel_name'];
		}else{
			$ks[$k]['kafala'] = "لا";
		}
	}
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/acp/kafeel.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>