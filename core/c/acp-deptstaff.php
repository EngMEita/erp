<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/depts.php");
require_once($rootPath."core/m/staff.php");
if(canSeePage('acp', $_SESSION['staff']['rolls'])){
	
	$dept_id = ( isset($_GET['dept_id']) && intval($_GET['dept_id']) > 0 ) ? intval($_GET['dept_id']) : 0;
	
	if(isset($_POST['act'])){
		switch($_POST['act']){
			case 'add':
				extract($_POST);
				if($sql->simple("INSERT INTO `dept_staff` VALUES ( '', ".$dept_id.", ".$staff_id.", ".$job_code.", '".$job_title."', '', ".$work_pos_id.", '".sysDate($dept_joindate)."', '', 1 )")) $ntf = "تمت العملية بنجاح";
			break;
			case 'edit':
				extract($_POST);
				if(isset($id) && intval($id) > 0){
					if($sql->simple("UPDATE `dept_staff` SET `job_code` = ".$job_code.", `job_title` = '".$job_title."', `work_pos_id` = ".$work_pos_id.", `dept_joindate` = '".sysDate($dept_joindate)."' WHERE `id` = ".$id)) $ntf = "تمت العملية بنجاح";
				}
			break;
		}
	}
	
	if(isset($_GET['act'], $_GET['rid'], $_GET['staff_id'], $_GET['change_id']) && $_GET['act'] == "changedept" && intval($_GET['rid']) > 0 && intval($_GET['staff_id']) > 0 && intval($_GET['change_id']) > 0){
		if(changeStaffDept(intval($_GET['rid']), intval($_GET['staff_id']), intval($_GET['change_id'])))  Redir('index.php?c=acp-deptstaff');
	}
	
	if(isset($_GET['delete']) && intval($_GET['delete']) > 0){
		if($sql->simple("DELETE FROM `dept_staff` WHERE `id` = ".intval($_GET['delete']))) Redir('index.php?c=acp-deptstaff&dept_id='.$dept_id);
	}
	
	$dept    = getDept($dept_id);
	if($dept){
		$deptId = $dept['dept_id'];
		$deptName = $dept['dept_name'];
	}else{
		$deptId = 0;
		$deptName = "مؤسسة بن جبرين الخيرية";
		$deptsArray = deptsListArray();
	}
	
	$parents = deptParents($dept_id);
	if($parents && is_array($parents)){
		$parentStr = '<a href="index.php?c=acp-depts&dept_id=0">مؤسسة بن جبرين الخيرية</a> &raquo; ';
		$parents = array_reverse($parents);
		unset($parents[0]);
		foreach($parents as $parent){
			$prnt = getDept($parent);	
			$parentStr .= '<a href="index.php?c=acp-depts&dept_id='.$prnt['dept_id'].'">'.$prnt['dept_name'].'</a> &raquo; ';
		}
	}else{
		$parentStr = '';
	}
	
	$dss = deptStaff($dept_id);
	$nds = notDis();
	$wps = workPos();
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/acp/deptstaff.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>