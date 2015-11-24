<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/messages.php");
if(isset($_SESSION['staff']['staff_id']) && intval($_SESSION['staff']['staff_id']) > 0){
	include($rootPath."core/v/header.php");
	
	$sid = intval($_SESSION['staff']['staff_id']);
	$mod = ( isset($_GET['mod']) && $_GET['mod'] != "" ) ? $_GET['mod'] : "new";
	switch($mod){
		case 'all':
			$pgTitle = "جميع الرسائل";
			$msgs = getMessages($sid);
			include($rootPath."core/v/messages.php");
		break;
		case 'new':
			$pgTitle = "الرسائل الجديدة";
			$msgs = getMessages($sid, 0);
			include($rootPath."core/v/messages.php");
		break;
		case 'archive':
			$pgTitle = "أرشيف الرسائل";
			$msgs = getMessages($sid, 2);
			include($rootPath."core/v/messages.php");
		break;
		case 'old':
			if(isset($_GET['id']) && intval($_GET['id']) > 0){
				$rid = intval($_GET['id']);
				archiveMessage($rid);
				Redir("index.php?c=messages&mod=archive");
			}
		break;
		case 'sent':
			$pgTitle = "الرسائل المرسلة";
			$msgs = myMessages($sid);
			include($rootPath."core/v/messages.php");
		break;
		case 'send':
			if(sendMessage($_POST['m'], $_POST['tos'], $_POST['from'], $_POST['a'])) Redir("index.php?c=messages&mod=sent");
			else RedirWM("index.php?c=messages&mod=compose", "خطأ في عملية الإرسال");
		break;
		case 'read':
			$pgTitle = "قراءة";
			if(isset($_GET['id']) && intval($_GET['id']) > 0){
				$rid = intval($_GET['id']);
				$msg = viewMessage($rid);
				include($rootPath."core/v/read.php");
			}else{
				Redir("index.php?c=messages&mod=all");	
			}
		break;
		case 'compose':
		default:
			if(isset($_GET['mid']) && intval($_GET['mid']) > 0){
				$pid = intval($_GET['mid']);
				$st  = isset($_GET['st']) && intval($_GET['st']) > 0 ? intval($_GET['st']) : 1;
				$om  = getMessage($pid);
			}else{
				$pid = NULL;
				$st  = 0;
				$om  = NULL;	
			}
			
			switch($st){
				case 2:
					$msgTtl = "إعادة توجيه: ";
					$pgTitle = "إعادة توجيه '".$om['message_title']." [ #".$om['message_id']." ]'";
				break;
				case 1:
					$msgTtl = "الرد: ";
					$pgTitle = "الرد على '".$om['message_title']." [ #".$om['message_id']." ]'";
				break;
				case 0:
				default:
					$msgTtl = "";
					$pgTitle = "رسالة جديدة";
				break;
			}
			
			include($rootPath."core/v/compose.php");
		break;
	}
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>