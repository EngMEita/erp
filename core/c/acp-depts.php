<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/depts.php");
if(canSeePage('acp', $_SESSION['staff']['rolls'])){
	
	if(isset($_POST['act'])){
		switch($_POST['act']){
			case 'add':
				if(addDept($_POST['dept_name'], $_POST['dept_parent'])) $ntf = "تم إضافة '".$_POST['dept_name']."' بنجاح.";
			break;
			case 'edit':
				if(isset($_POST['dept_id']) && $_POST['dept_id'] > 0){
					if(editDept($_POST['dept_name'], $_POST['dept_id'])) $ntf = "تم تحديث '".$_POST['dept_name']." [ ".$_POST['dept_id']." ] ' بنجاح.";
				}
			break;
		}
	}
	
	if(isset($_GET['delete']) && $_GET['delete'] > 0){
		$pr = deleteDept($_GET['delete']);
		if($pr > 0) Redir('index.php?c=acp-depts&dept_id='.$pr);
	}
	
	if(isset($_GET['dept_id']) && intval($_GET['dept_id']) > 0){
		$dept_id = intval($_GET['dept_id']);
	}else{
		$dept_id = 0;
	}
	
	$dept    = getDept($dept_id);
	if($dept){
		$deptId = $dept['dept_id'];
		$deptName = $dept['dept_name'];
	}else{
		$deptId = 0;
		$deptName = "مؤسسة بن جبرين الخيرية";
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
	
	$childs  = deptChilds($dept_id);
		
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/acp/deptslist.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>