<?php
require_once($rootPath."core/m/global.php");
if(canSeePage('acp', $_SESSION['staff']['rolls'])){
	if(isset($_POST['act'])){
		switch($_POST['act']){
			case 'add':
				if($sql->simple("INSERT INTO `work_pos` VALUES ( '', '".$_POST['work_pos_title']."', '".$_POST['work_pos_rank']."' )")) $ntf = "تم إضافة '".$_POST['work_pos_title']."' بنجاح.";
			break;
			case 'edit':
				if(isset($_POST['work_pos_id']) && $_POST['work_pos_id'] > 0){
					if($sql->simple("UPDATE `work_pos` SET `work_pos_title` = '".$_POST['work_pos_title']."', `work_pos_rank` = '".$_POST['work_pos_rank']."' WHERE `work_pos_id` = ".$_POST['work_pos_id'])) $ntf = "تم تحديث '".$_POST['work_pos_title']." [ ".$_POST['work_pos_id']." ] ' بنجاح.";
				}
			break;
		}
	}
	
	if(isset($_GET['delete']) && $_GET['delete'] > 0){
		if($sql->simple("DELETE FROM `work_pos` WHERE `work_pos_id` = ".$_GET['delete'])) Redir('index.php?c=acp-workpos');
	}
	
	$ws = $sql->query("SELECT * FROM `work_pos` ORDER BY `work_pos_rank` ASC");
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/acp/workpos.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>