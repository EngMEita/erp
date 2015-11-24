<?php
require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
require_once($rootPath."core/m/staff.php");
require_once($rootPath."core/m/plans.php");

function colorStatus($s){
	switch($s){
		case 1:
		case 2:
			$out = ' style="background-color:#0FF;"';
		break;
		case 3:
		case 4:
			$out = ' style="background-color:#3F9;"';
		break;
		case 5:
		case 6:
			$out = ' style="background-color:#F96;"';
		break;
		case 7:
			$out = ' style="background-color:#A207FE;"';
		break;
		case 0:
		default:
			$out = '';
		break;
	}
	return $out;
}

if( ( canSeePage( 'ccp', $_SESSION['staff']['rolls'] ) || canSeePage( 'hcp', $_SESSION['staff']['rolls'] ) || canSeePage( 'fcp', $_SESSION['staff']['rolls'] ) ) && ( isset($_GET['mid']) && intval($_GET['mid']) > 0 ) ){
	$mid = intval($_GET['mid']);
	$month = getMonth($mid);
	
	$mss = $sql->query("SELECT * FROM `plan_month_shifts` WHERE `plan_month_id` = ".$mid." ORDER BY `shift_id` ASC");
	$shs = array();
	foreach($mss as $ms){
		$shs[$ms["shift_id"]] = array("in" => $ms["shift_in"], "out" => $ms["shift_out"]);
	}
	
	if($month){
		
		if(isset($_GET['day_id']) && intval($_GET['day_id']) > 0){
			$day_id = intval($_GET['day_id']);
			$pst = "&day_id=".$day_id;					
		}else{
			$staff_id = intval($_GET['staff_id']);
			$pst = "&staff_id=".$staff_id;				
		}
		
		if(isset($_GET['act']) && $_GET['act'] == "save"){
			extract($_POST);
			$ok = 0;
			foreach($ids as $id){
				if(saveTimesheet($in[$id], $out[$id], $status[$id], $comment[$id], $id)) $ok++;
			}
			if($ok > 0){ Redir("index.php?c=hcp-timesheet&mid=".$mid.$pst."#timesheet"); }
		}elseif(isset($_GET['act']) && $_GET['act'] == "saveextras"){
			foreach($_POST as $ex_n => $ex_v){
				$exn = "ex_".$ex_n;
				$$exn = $ex_v;
			}
			
			if(isset($_GET['extra_id']) && intval($_GET['extra_id']) > 0){
				$extra_id = intval($_GET['extra_id']);
				if(editExtra($ex_extra_day, $ex_extra_opr, $ex_extra_from, $ex_extra_to, $ex_comment, $extra_id)){ Redir("index.php?c=hcp-timesheet&mid=".$mid.$pst."#extras"); }
			}else{
				if(newExtra($ex_staff_id, $ex_month_id, $ex_extra_day, $ex_extra_opr, $ex_extra_from, $ex_extra_to, $ex_comment)){ Redir("index.php?c=hcp-timesheet&mid=".$mid.$pst."#extras"); }
			}
		}elseif(isset($_GET['act'], $_GET['sms_id']) && $_GET['act'] == "savesummary" && intval($_GET['sms_id']) > 0){
			$sms_id = intval($_GET['sms_id']);
			foreach($_POST as $sms_n => $sms_v){
				$smsn = "sms_".$sms_n;
				$$smsn = $sms_v;
			}
			if(saveMonthlySummary($sms_dr, $sms_dc, $sms_ar, $sms_ac, $sms_hd, $sms_er, $sms_ec, $sms_comment, $sms_id)){ Redir("index.php?c=hcp-timesheet&mid=".$mid.$pst."#sms"); }
		}elseif(isset($_GET['act']) && $_GET['act'] == "savemoneysheet"){
			if(saveStaffMoneySheet($_POST['msh'], $_POST['id'])) Redir("index.php?c=hcp-timesheet&mid=".$mid."&staff_id=".$staff_id);
		}
		
		
		if(isset($_GET['deleteextra']) && intval($_GET['deleteextra']) > 0){
			$extra_id = intval($_GET['deleteextra']);
			if(deleteExtra($extra_id)) Redir("index.php?c=hcp-timesheet&mid=".$mid.$pst."#extras");
		}
		
		if(isset($day_id) && $day_id > 0){
			$ad = formatDate(Fld("plan_month_days", "day_id", $day_id, "day_date"), "dd MM yyyy");
			$ho = Fld("plan_month_days", "day_id", $day_id, "day_order");
			$wd = Fld("week_days", "week_day_id", Fld("plan_month_days", "day_id", $day_id, "week_day_id"), "week_day_name");
			$tx = $wd." ".$ho." من ".$month['ar_month_name']." الموافق ".$ad;
			$tss = dayTimesheet($day_id, $mid);
			$days = planMonthDays($mid);
			$ddMenu = "\n".'<select name="monthDays_'.$mid.'" id="monthDays_'.$mid.'" size="1" onchange="openURL(\'monthDays_'.$mid.'\',\'\');">'."\r";
			foreach($days as $day){
				$sel = $day['day_id'] == $day_id ? " selected" : "";
				$ddMenu .= "\n\t".'<option value="index.php?c=hcp-timesheet&mid='.$mid.'&day_id='.$day['day_id'].'"'.$sel.'>'.Fld("week_days", "week_day_id", $day['week_day_id'], "week_day_name").', '.$day['day_order'].' '.Fld("ar_months", "ar_month_id", $mid, "ar_month_name").' ( '.formatDate($day['day_date'], "dd-mm-yyyy").' )</option>'."\r";
			}
			$ddMenu.= "\n".'</select>'."\n";
		}elseif(isset($staff_id) && $staff_id > 0){
			$tx = Fld("staff", "staff_id", $staff_id, "staff_fullname");
			$tss = staffTimesheet($staff_id, $mid);
			$sts = staffList();
			$ddMenu = "\n".'<select name="staffList_'.$mid.'" id="staffList_'.$mid.'" size="1" onchange="openURL(\'staffList_'.$mid.'\',\'\');">'."\r";
			foreach($sts as $s){
				$sel = $s['staff_id'] == $staff_id ? " selected" : "";
				$ddMenu .= "\n\t".'<option value="index.php?c=hcp-timesheet&mid='.$mid.'&staff_id='.$s['staff_id'].'"'.$sel.'>'.$s['staff_fullname'].'</option>'."\r";
			}
			$ddMenu.= "\n".'</select>'."\r";
			
			$dr = 0; //real lates in min.
			$dc = 0; //counted lates in min.
			$hd = 0; //halfdays in half-days
			$ar = 0; //real absence in days
			$ws = 0; //without salary
			$ac = 0; //counted absence in days
			$er = 0; //real extras in hours
			$ec = 0; //counted extras in hours
		}else{
			include($rootPath."core/v/banned.php");
			die();	
		}
		
		include($rootPath."core/v/header.php");
		include($rootPath."core/v/hcp/timesheet.php");
		if(isset($staff_id)){
			if(canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){
				$preM = getPreMonth($mid);
				if(intval($preM['plan_month_id']) > 0){
					$exs = staffExtras($staff_id, intval($preM['plan_month_id']));
					if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )) include($rootPath."core/v/hcp/staffextras.php");
					$sms = staffMonthlySummary($staff_id, intval($preM['plan_month_id']));
					if($sms) include($rootPath."core/v/hcp/staffmonthsummary.php");
				}
			}else{
				$exs = staffExtras($staff_id, $mid);
				if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )) include($rootPath."core/v/hcp/staffextras.php");
				$sms = staffMonthlySummary($staff_id, $mid);
				if($sms) include($rootPath."core/v/hcp/staffmonthsummary.php");
			}
			
			if(canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){
				$stPln = staffPlan($staff_id, $month['plan_id']);
				$moneysheet = staffMoneySheet($staff_id, $mid);
				include($rootPath."core/v/fcp/staffmoneysheet.php");
				echo"<!-- <pre>";
				print_r($moneysheet);
				echo"</pre> -->";
			}
		}
		include($rootPath."core/v/footer.php");
	}else{
		include($rootPath."core/v/banned.php");
	}
}else{
	include($rootPath."core/v/banned.php");
}
?>