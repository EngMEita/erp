<?php
require_once($rootPath."core/m/global.php");
if(canSeePage('acp', $_SESSION['staff']['rolls'])){
	if(isset($_POST['act'])){
		switch($_POST['act']){
			case 'add':
				if($sql->simple("INSERT INTO `countries` VALUES ( '', '".$_POST['country_name']."', '".$_POST['country_nationality']."' )")) $ntf = "تم إضافة '".$_POST['country_name']."' بنجاح.";
			break;
			case 'edit':
				if(isset($_POST['country_id']) && $_POST['country_id'] > 0){
					if($sql->simple("UPDATE `countries` SET `country_name` = '".$_POST['country_name']."', `country_nationality` = '".$_POST['country_nationality']."' WHERE `country_id` = ".$_POST['country_id'])) $ntf = "تم تحديث '".$_POST['country_name']." [ ".$_POST['country_id']." ] ' بنجاح.";
				}
			break;
		}
	}
	
	if(isset($_GET['delete']) && $_GET['delete'] > 0){
		if($sql->simple("DELETE FROM `countries` WHERE `country_id` = ".$_GET['delete'])) Redir('index.php?c=acp-countries');
	}
	
	$cs = $sql->query("SELECT * FROM `countries`");
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/acp/countries.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>