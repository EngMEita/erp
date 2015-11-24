<?php
function getCirculars($id = 0){
	$sql = $GLOBALS['sql'];
	$txt = "SELECT * FROM `circulars`";
	if(intval($id) > 0) $txt .= " WHERE `circular_id` = ".$id;
	$txt .= " ORDER BY `circular_id` DESC";
	$res = $sql->query($txt);
	$out = array();
	$i = 0;
	foreach($res as $r){
		$out[$i] = array();
		
		foreach($r as $f => $v){
			$out[$i][$f] = $v;
		}
		$sss = $sql->query("SELECT `staff_id` FROM `circulars_signes` WHERE `circular_id` = ".$r['circular_id']);
		$out[$i]['viewers'] = array();
		foreach($sss as $s){
			$out[$i]['viewers'][] = $s['staff_id'];
		}
		$out[$i]['views'] = count($sss);
		if(in_array($_SESSION['staff']['staff_id'], $out[$i]['viewers']) || $r['staff_id'] == $_SESSION['staff']['staff_id']) $out[$i]['new'] = 0;
		else $out[$i]['new'] = 1;
		
		if($id > 0 && $out[$i]['new'] > 0 && $r['staff_id'] != $_SESSION['staff']['staff_id']){
			$tdh = $GLOBALS['tdh'];
			$sql->simple("INSERT INTO `circulars_signes` VALUES( '', ".$r['circular_id'].", ".$_SESSION['staff']['staff_id'].", '".$tdh."', ".time().", -1, NULL )");
		}
		if($r['staff_id'] == $_SESSION['staff']['staff_id']) $xxx = $sql->query("SELECT * FROM `circulars_signes` WHERE `circular_id` = ".$r['circular_id']." ORDER BY `signe_time` ASC");
		else  $xxx = $sql->query("SELECT * FROM `circulars_signes` WHERE `circular_id` = ".$r['circular_id']." AND `staff_id` = ".$_SESSION['staff']['staff_id']." LIMIT 1");
		$out[$i]['signs'] = array();
		foreach($xxx as $x){
			$out[$i]['signs'][] = $x;	
		}
		$i++;
	}
	//print_r($out);
	return $out;
}

function saveCircular($data, $id = 0){
	$sql = $GLOBALS['sql'];
	if($id > 0) $txt = "UPDATE `circulars` SET {XXXX} WHERE `circular_id` = ".$id;
	else $txt = "INSERT INTO `circulars` SET {XXXX}";
	$flds = array();
	foreach($data as $fld => $vlu){
		$flds[] = "`".$fld."` = '".$vlu."'";
	}
	$str = implode(", ", $flds);
	$txt = str_replace("{XXXX}", $str, $txt);
	if($sql->simple($txt)) return true;
	return false;
}

function saveSigne($fld, $vlu, $id){
	$sql = $GLOBALS['sql'];
	return $sql->simple("UPDATE `circulars_signes` SET `".$fld."` = '".$vlu."' WHERE `id` = ".$id);
}

function deleteCircular($id){
	$sql = $GLOBALS['sql'];
	if(toArchive("circulars", "circular_id", $id)){
		if($sql->simple("DELETE FROM `circulars` WHERE `circular_id` = ".$id)) return true;
	}
	return false;
}

function circularPeriorty($pr){
	switch($pr){
		case 3:
			return "هام وعاجل";
		break;
		case 2:
			return "هام";
		break;
		case 1:
			return "عاجل";
		break;
		case 0:
		default:
			return "عادي";
		break;
	}
}

function circularStatus($pr){
	switch($pr){
		case 3:
			return "لإبداء الرأي والتعليق";
		break;
		case 2:
			return "للتعليق";
		break;
		case 1:
			return "لإبداء الرأي";
		break;
		case 0:
		default:
			return "للإطلاع";
		break;
	}
}

?>