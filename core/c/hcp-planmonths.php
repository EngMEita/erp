<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");

$r = isset($_GET['r']) ? $_GET['r'] : $_SESSION['staff']['rolls'][0];

if(canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('fcp', $_SESSION['staff']['rolls'])){
	
	
	if(isset($_GET['plan_id']) && intval($_GET['plan_id']) > 0) $plan = getPlan(intval($_GET['plan_id']));
	else $plan = getPlan();
	
	if(isset($_GET['mid']) && intval($_GET['mid']) > 0){
		if(planMonthDays(intval($_GET['mid']))) Redir("index.php?hcp-planmonths&plan_id=".$plan['plan_id']);
	}
	
	if(isset($_POST['act']) && $_POST['act'] == "change"){
		if(planMonthsChange($_POST['plan_id'], $_POST['months'])) $notf= "";
	}
	
	$months = planMonths($plan['plan_id']);
	$staff = staffList();
	foreach($months as $k => $v){
		if(monthDays($v['plan_month_id'])){ 
			$str = "\n".'<select name="monthDays_'.$v['plan_month_id'].'" id="monthDays_'.$v['plan_month_id'].'" size="1" onchange="openURL(\'monthDays_'.$v['plan_month_id'].'\',\'\');">'."\r\n\t".'<option value="index.php?c=hcp-planmonths&plan_id='.$plan['plan_id'].'">اختر اليوم</option>'."\r";
			$days = planMonthDays($v['plan_month_id']);
			foreach($days as $day){
				$str .= "\n\t".'<option value="index.php?c=hcp-timesheet&mid='.$v['plan_month_id'].'&day_id='.$day['day_id'].'">'.Fld("week_days", "week_day_id", $day['week_day_id'], "week_day_name").', '.$day['day_order'].' '.Fld("ar_months", "ar_month_id", $v['ar_month_id'], "ar_month_name").' ( '.formatDate($day['day_date'], "dd MM yyyy").' )</option>'."\r";
			}
			$str.= "\n".'</select>'."\n";
			$months[$k]['days'] = $str;
		}else{
			$months[$k]['days'] = '<input type="button" name="monthDays" value="أيام الشهر" onclick="window.location = \'index.php?c=hcp-planmonths&plan_id='.$plan['plan_id'].'&mid='.$v['plan_month_id'].'\';" />';
		}
		
		$str = "\n".'<select name="staffList_'.$v['plan_month_id'].'" id="staffList_'.$v['plan_month_id'].'" size="1" onchange="openURL(\'staffList_'.$v['plan_month_id'].'\',\'\');">'."\r\n\t".'<option value="index.php?c=hcp-planmonths&plan_id='.$plan['plan_id'].'">اختر الموظف</option>'."\r";
		foreach($staff as $s){
			$str .= "\n\t".'<option value="index.php?c=hcp-timesheet&mid='.$v['plan_month_id'].'&staff_id='.$s['staff_id'].'">'.$s['staff_fullname'].'</option>'."\r";
		}
		$str.= "\n".'</select>'."\r";
		$months[$k]['staff'] = $str;
	}
	
	
	
	include($rootPath."core/v/header.php");
	include($rootPath."core/v/hcp/months.php");
	include($rootPath."core/v/footer.php");
}else{
	include($rootPath."core/v/banned.php");
}
?>