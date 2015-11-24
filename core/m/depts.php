<?php
function addDept($title, $parent = 0){
	$sql = $GLOBALS['sql'];
	if($parent > 0){
		$txt = "INSERT INTO `depts` VALUES ( '', '".$parent."', '".$title."' )";	
	}else{
		$txt = "INSERT INTO `depts` VALUES ( '', NULL, '".$title."' )";	
	}
	if($sql->simple($txt)) return true;
	return false;
}

function editDept($title, $id){
	$sql = $GLOBALS['sql'];
	if($sql->simple("UPDATE `depts` SET `dept_name` = '".$title."' WHERE `dept_id` = ".$id)) return true;
	return false;
}

function chngDeptPrnt($prnt, $id){
	$sql = $GLOBALS['sql'];
	if($prnt > 0){
		$txt = "UPDATE `depts` SET `dept_parent` = '".$prnt."' WHERE `dept_id` = ".$id;
	}else{
		$txt = "UPDATE `depts` SET `dept_parent` = NULL WHERE `dept_id` = ".$id;
	}
	if($sql->simple($txt)) return true;
	return false;
		
}

function deleteDept($id){
	$sql = $GLOBALS['sql'];
	$dept = $sql->query("SELECT * FROM `depts` WHERE `dept_id` = ".$id);
	if(count($dept) > 0){
		if($sql->simple("DELETE FROM `depts` WHERE `dept_id` = ".$id)) return intval($dept[0]['dept_parent']);
	}
	return false;
}

function getDept($id){
	if($id > 0){
		$sql = $GLOBALS['sql'];
		$depts = $sql->query("SELECT * FROM `depts` WHERE `dept_id` = ".$id." LIMIT 1");
		return $depts[0];
	}else{
		return false;	
	}
}

function deptParent($id){
	$sql = $GLOBALS['sql'];
	$depts = $sql->query("SELECT `dept_parent` FROM `depts` WHERE `dept_id` = ".$id." LIMIT 1");
	if(intval($depts[0]['dept_parent']) > 0){
		return getDept($depts[0]['dept_parent']);
	}
	return false;
}

function deptParents($id, $parents = array()){
	if($id > 0){
		$sql = $GLOBALS['sql'];
		$depts = $sql->query("SELECT * FROM `depts` WHERE `dept_id` = ".$id." LIMIT 1");
		$parents[] = $depts[0]['dept_parent'];
		if(intval($depts[0]['dept_parent']) > 0){
			$parents = deptParents($depts[0]['dept_parent'], $parents);
		}
		return $parents;
	}else{
		return false;
	}
}

function deptParentsTest($id, $parents = array()){
	$sql = $GLOBALS['sql'];
	$depts = $sql->query("SELECT * FROM `testdepts` WHERE `id` = ".$id." LIMIT 1");
	$parents[$id] = $depts[0]['parent'];
	if(intval($depts[0]['parent']) > 0){
		$parents = deptParentsTest($depts[0]['parent'], $parents);
	}
	return $parents;
}


function deptChilds($prnt){
	$sql = $GLOBALS['sql'];
	if($prnt === 0){
		$txt = "SELECT * FROM `depts` WHERE `dept_parent` IS NULL ORDER BY `dept_name` ASC";
	}else{
		$txt = "SELECT * FROM `depts` WHERE `dept_parent` = ".$prnt." ORDER BY `dept_name` ASC";
	}
	
	$depts = $sql->query($txt);
	if(count($depts) > 0){
		$out = array();
		$i = 0;
		foreach($depts as $dept){
			$out[$i] = array();
			foreach($dept as $k => $v){
				$out[$i][$k] = $v;
			}
			$out[$i]['staff'] = deptStaffCount($dept['dept_id']);
			$out[$i]['head'] = deptHead($dept['dept_id']);
			$i++;
		}
		return $out;
	}
	return false;
}

function deptHead($id){
	$sql = $GLOBALS['sql'];
	$staff = $sql->query("SELECT a.`staff_id`, a.`dept_id`, b.`staff_fullname`, c.`work_pos_rank` FROM `dept_staff` a, `staff` b, `work_pos` c WHERE b.`staff_id` = a.`staff_id` AND c.`work_pos_id` = a.`work_pos_id` AND a.`dept_id` = ".$id." ORDER BY c.`work_pos_rank` ASC LIMIT 1");
	if(count($staff) > 0){
		return $staff[0]['staff_fullname'];
	}
	return false;
}

function deptStaff($id){
	$deptId = $id > 0 ? $id : "%";
	$sql = $GLOBALS['sql'];
	$staff = $sql->query("SELECT * FROM `dept_staff` WHERE `dept_id` LIKE '".$deptId."' AND `status` = 1 ORDER BY `work_pos_id` ASC");
	if(count($staff) > 0){
		return $staff;
	}
	return false;
}

function notDis(){
	$sql = $GLOBALS['sql'];
	$staff = $sql->query("SELECT `staff_id`, `staff_fullname` FROM `staff` WHERE `staff_id` NOT IN ( SELECT `staff_id` FROM `dept_staff` WHERE `status` = 1 ) ORDER BY `staff_fullname` ASC");
	if(count($staff) > 0){
		return $staff;
	}
	return false;
}

function deptStaffCount($id){
	$sql = $GLOBALS['sql'];
	$staff = $sql->query("SELECT count(*) AS 'c' FROM `dept_staff` WHERE `dept_id` = ".$id." AND `status` = 1");
	return $staff[0]['c'];
}

function workPos(){
	$sql = $GLOBALS['sql'];
	$wps = $sql->query("SELECT `work_pos_id`, `work_pos_title` FROM `work_pos` ORDER BY `work_pos_rank` ASC ");
	if(count($wps) > 0){
		return $wps;
	}
	return false;	
}

function deptsListArray(){
	$sql = $GLOBALS['sql'];	
	$depts = $sql->query("SELECT * FROM `depts`");
	$deptsArray = array();
	foreach($depts as $dept){
		$dept_parent = intval($dept['dept_parent']);
		$dept_id = intval($dept['dept_id']);
		$deptsArray[$dept_id] = array("dept_id" => $dept_id, "dept_parent" => $dept_parent, "dept_name" => $dept['dept_name']);
	}
	return $deptsArray;
}

function deptsListDD($array, $parent = 0, $level = 0, $sel = -1, $des = -1){
	$has_children = false;
	foreach($array as $key => $value){
		if($value['dept_parent'] == $parent){
			if($has_children === false){
				$has_children = true;
				$level++;
				$x = "";
				for($i = 0; $i < $level-1; $i++){ $x .= "+----"; }
			}
			$y = ( $sel == $value['dept_id'] ) ? " selected='selected'" : "";
			$z = ( $des == $value['dept_id'] ) ? " disabled='disabled'" : "";
			$j = ( $des == $parent ) ? " disabled='disabled'" : ""; 
			echo "\n\t<option value='".$value['dept_id']."'".$y.$z.$j.">".$x."&nbsp;".$value['dept_name']."</option>\r";
			deptsListDD($array, $key, $level, $sel, $des);
		}
	}
}

function changeStaffDept($rid, $staff_id, $dept_id){
	$sql = $GLOBALS['sql'];
	$lwd = $GLOBALS['lwd'];
	$dld = innerDate($lwd['day_date']);
	$djd = $GLOBALS['tdh'];
	$cdp = $sql->query("SELECT * FROM `dept_staff` WHERE `id` = ".$rid);
	if($sql->simple("UPDATE `dept_staff` SET `dept_leavedate` = '".$dld."', `status` = 0 WHERE `id` = ".$rid)){
		if($sql->simple("INSERT INTO `dept_staff` VALUES ( '', ".$dept_id.", ".$staff_id.", '".$cdp[0]['job_code']."', '".$cdp[0]['job_title']."', '".$cdp[0]['job_desc']."', '".$cdp[0]['work_pos_id']."', '".$djd."', '', 1 )")) return true;
		return false;
	}
	return false;
}

?>