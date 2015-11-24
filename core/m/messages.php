<?php
function sendMessage( array $message, $to, $from, array $attach){
	$sql = $GLOBALS['sql'];
	$txt = "INSERT INTO `messages` SET `staff_id` = ".$from.", `message_date` = '".date("Ymd")."A', `message_time` = '".time()."'";
	$tos = explode(",", $to);
	$message['message_attachments'] = messageAttachments($attach);
	foreach($message as $f => $v){
		$txt .= ", `".$f."` = '".mysql_real_escape_string($v)."'";
	}
	
	if($sql->simple($txt)){
		$mid = $sql->insertedId();
		foreach($tos as $sid){
			$sql->simple("INSERT INTO `message_recipient` SET `message_id` = '".$mid."', `staff_id` = '".$sid."'");
		}
		return true;
	}
	return false;
}

function getMessages($staff_id, $status = "%"){
	$sql = $GLOBALS['sql'];
	$messages = $sql->query("SELECT * FROM `message_recipient` WHERE `staff_id` = ".$staff_id." AND `message_status` LIKE '".$status."'");
	if(count($messages) > 0){
		$out = array();
		$i = 0;
		foreach($messages as $m){
			$out[$i]['data'] = $m;
			$out[$i]['content'] = getMessage($m['message_id']);
			$i++;
		}
		return $out;
	}
	return false;
}

function getMessageId($read_id){
	$sql = $GLOBALS['sql'];
	$msg = $sql->query("SELECT `message_id` FROM `message_recipient` WHERE `id` = ".$read_id);
	if(count($msg) > 0){
		return $msg[0]['message_id'];
	}
	return false;
}

function getMessage($message_id, $read_id = 0){
	$sql = $GLOBALS['sql'];
	$message = $sql->query("SELECT * FROM `messages` WHERE `message_id` = ".$message_id);
	if(count($message) > 0){
		if(intval($read_id) > 0) readMessage($read_id);
		return $message[0];
	}
	return false;
}

function newMessages($staff_id){
	$ms = getMessages($staff_id, 0);
	$out = 0;
	foreach($ms as $m){
		$out++;	
	}
	return $out;
}

function myMessages($staff_id){
	$sql = $GLOBALS['sql'];
	$messages = $sql->query("SELECT * FROM `messages` WHERE `staff_id` = ".$staff_id);
	if(count($messages) > 0){
		$out = array();
		$i = 0;
		foreach($messages as $m){
			$tos = $sql->query("SELECT * FROM `message_recipient` WHERE `message_id` = ".$m['message_id']);
			foreach($tos as $to){
				$out[$i]['data'] = $to;
				$out[$i]['content'] = $m;
				$i++;
			}
		}
		return $out;
	}
	return false;
}

function readMessage($read_id){
	$sql = $GLOBALS['sql'];
	if($sql->simple("UPDATE `message_recipient` SET `reading_date` = '".date("Ymd")."A', `reading_time` = '".time()."', `message_status` = '1' WHERE `id` = ".$read_id)) return true;
	return false;
}

function viewMessage($rid){
	$sql = $GLOBALS['sql'];
	$messages = $sql->query("SELECT * FROM `message_recipient` WHERE `id` = ".$rid." LIMIT 1");
	if(count($messages) > 0){
		$out = array();
		$i = 0;
		foreach($messages as $m){
			$out[$i]['data'] = $m;
			$out[$i]['content'] = getMessage($m['message_id']);
			$i++;
		}
		if($messages[0]['staff_id'] == $_SESSION['staff']['staff_id'] && $messages[0]['message_status'] < 1 ) $sql->simple("UPDATE `message_recipient` SET `reading_date` = '".date("Ymd")."A', `reading_time` = '".time()."', `message_status` = '1' WHERE `id` = ".$rid);
		return $out[0];
	}
	return false;
}

function archiveMessage($read_id){
	$sql = $GLOBALS['sql'];
	if($sql->simple("UPDATE `message_recipient` SET `message_status` = '2' WHERE `id` = ".$read_id)) return true;
	return false;
}

function messageAttachments(array $files){
	$fs = array();
	foreach($files as $f){
		$fs[] = upload($f, "attachments", "all");
	}
	$out = array();
	foreach($fs as $f){
		if($f != "") $out[] = "<a href='attachments/".$f."' target='_blank'>".$f."</a>";
	}
	if(count($out) > 0) return implode("<br />", $out);
	return NULL;
}

function messageStatus($read_id){
	$sql = $GLOBALS['sql'];
	$msg = $sql->query("SELECT * FROM `message_recipient` WHERE `id` = ".$read_id);
	if(count($msg) > 0){
		switch($msg[0]['message_status']){
			case 2:
				return "مؤرشفة";
			break;
			case 1:
				return "مقروءة";
			break;
			case 0:
				return "جديدة";
			break;
			default:
				return "";
			break;
		}
	}
	return "";
}

function messageReadingTime($read_id){
	$sql = $GLOBALS['sql'];
	$msg = $sql->query("SELECT * FROM `message_recipient` WHERE `id` = ".$read_id);
	if(count($msg) > 0 && !is_null($msg[0]['reading_date'])){
		return "( بتاريخ: ".formatDate(innerDate($msg[0]['reading_date']), "yyyy/mm/dd T")." )";
	}
	return "";
}

function getTos($id = 0, $sel = false){
	$sql = $GLOBALS['sql'];
	$opr = $sel ? "=" : "!=";
	$tos = $sql->query("SELECT `staff_id` AS 'id', `staff_fullname` AS 'name' FROM `staff` WHERE `staff_id` ".$opr." ".$id." ORDER BY `staff_fullname` ASC");
	$out = array();
	foreach($tos as $to){
		$out[] = '{id: '.$to['id'].', name: "'.$to['name'].'"}';
	}
	$str = implode(",",$out);
	return $str;
}

?>