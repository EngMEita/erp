<?php
require($rootPath.'inc/I18N/Arabic.php'); 
$Arabic = new I18N_Arabic('Numbers'); 
////////////////////////////File types//////////////////////
function VExts($type){
	switch($type){
		case'images':
			$exts = array('png','gif','jpg','jpeg');
		break;
		case'files':
			$exts = array('zip','rar','7z','iso');
		break;
		case'docs':
			$exts = array('doc','docx','pdf');
		break;
		case'video':
			$exts = array('mp4','webm','ogg');
		break;
		case'audio':
			$exts = array('mp3','wav','ogg');
		break;
		case'media':
			$exts = array('zip','rar','7z');
		break;
		case'all':
			$exts = array('png','gif','jpg','jpeg','mp3','wav','zip','rar','7z','iso','doc','docx','pdf','ppt','pptx','txt','xls','xlsx');
		break;
		case'work':
			$exts = array('jpg','jpeg','doc','docx','pdf');
		break;
		case 'lib':
			$exts = array('mp3','wav','zip','rar','doc','docx','pdf','ppt','pptx');
		break;
	}
	return $exts;
}
/////////////////////ext//////////////////////////////
function Ext($name){
	$ext = end(explode('.',$name));
	$ext = strtolower($ext);
	return $ext;
}
/////////////////////arabic date/////////////////////////////
function arDate($xxxx){
	
	$date = date($xxxx);
	
	$days = array();
	$days["Saturday"]  = "السبت";
	$days["Sunday"]    = "الأحد";
	$days["Monday"]    = "الإثنين";
	$days["Tuesday"]   = "الثلاثاء";
	$days["Wednesday"] = "الأربعاء";
	$days["Thursday"]  = "الخميس";
	$days["Friday"]    = "الجمعة";
	
	$monthes = array();
	$monthes["January"]   = "يناير";
	$monthes["February"]  = "فبراير";
	$monthes["March"]     = "مارس";
	$monthes["April"]     = "أبريل";
	$monthes["May"]       = "مايو";
	$monthes["June"]      = "يونية";
	$monthes["July"]      = "يولية";
	$monthes["August"]    = "أغسطس";
	$monthes["September"] = "سبتمبر";
	$monthes["October"]   = "أكتوبر";
	$monthes["November"]  = "نوفمبر";
	$monthes["December"]  = "ديسمبر";
	
	$times = array();
	$times["am"] = "ص";
	$times["pm"] = "م";
	
	foreach($days as $en=>$ar){
		$date = str_replace($en,$ar,$date);
	}
	
	foreach($monthes as $en=>$ar){
		$date = str_replace($en,$ar,$date);
	}
	
	foreach($times as $en=>$ar){
		$date = str_replace($en,$ar,$date);
	}
	
	return $date;
}

/////////////////////// get date string f for full s for short//////////////////////
function outDateQuick($date, $t = "f"){
	$out = outDate($date);
	switch($t){
		case 'f':
			$x = $out['d']." ".$out['M']." ".$out['y']." ".$out['T'];
		break;
		case 's':
			$x = $out['y']."/".$out['m']."/".$out['d'];
		break;
		case 'cf':
			$x = $out['c']['d']." ".$out['c']['M']." ".$out['c']['y']." ".$out['c']['T'];
		break;
		case 'cs':
			$x = $out['c']['y']."/".$out['c']['m']."/".$out['c']['d'];
		break;
	}
	return $x;
}

function formatDate($date, $f = "yyyy-mm-dd"){
	$prts = outDate($date);
	$rep1 = array("yyyy", "mm", "MM", "dd", "t", "T");
	$rep2 = array($prts['y'], $prts['m'], $prts['M'], $prts['d'], $prts['t'], $prts['T']);
	$out = str_replace($rep1, $rep2, $f);
	return $out;
}


function outDate($date){		
	$monthes = array();
	$monthes["01"] = array("A" => "يناير", 	"H" => "محرم");
	$monthes["02"] = array("A" => "فبراير",  "H" => "صفر");
	$monthes["03"] = array("A" => "مارس", 	 "H" => "ربيع أول");
	$monthes["04"] = array("A" => "أبريل", 	"H" => "ربيع آخر");
	$monthes["05"] = array("A" => "مايو", 	 "H" => "جمادى الأولى");
	$monthes["06"] = array("A" => "يونية", 	"H" => "جمادى الأخرة");
	$monthes["07"] = array("A" => "يولية", 	"H" => "رجب");
	$monthes["08"] = array("A" => "أغسطس", 	"H" => "شعبان");
	$monthes["09"] = array("A" => "سبتمبر",  "H" => "رمضان");
	$monthes["10"] = array("A" => "أكتوبر",  "H" => "شوال");
	$monthes["11"] = array("A" => "نوفمبر",  "H" => "ذو القعدة");
	$monthes["12"] = array("A" => "ديسمبر",  "H" => "ذو الحجة");
	
	$types = array("A" => "م", "H" => "هـ");
	
	$out = array();
	$out['y'] = substr($date,0,4);
	$out['m'] = substr($date,4,2);
	$out['d'] = substr($date,6,2);
	$out['t'] = substr($date,8,1);
	$out['T'] = $types[$out['t']];
	$out['M'] = $monthes[$out['m']][$out['t']];
	$t = ( $out['t'] == "H" ) ? "A" : "H";
	$d = $out['y']."/".$out['m']."/".$out['d'];
	$out['c'] = array();
	$temp = dateConvert($d,$t);
	list($d,$m,$y) = explode("-",$temp);
	$out['c']['y'] = $y;
	$out['c']['m'] = $m;
	$out['c']['d'] = $d;
	$out['c']['t'] = $t;
	$out['c']['T'] = $types[$out['c']['t']];
	$out['c']['M'] = $monthes[$out['c']['m']][$out['c']['t']];
	return $out;	
}

function reverseDate($date){
	if($date[8] == "A") return innerDate($date);
	elseif($date[8] == "H") return aDate($date);
	else return revDate($date);
}

function revDate($date){
	$out = array();
	$out['y'] = substr($date,0,4);
	$out['m'] = substr($date,4,2);
	$out['d'] = substr($date,6,2);
	$out['t'] = substr($date,8,1);
	$t = ( $out['t'] == "H" ) ? "A" : "H";
	$d = $out['y']."/".$out['m']."/".$out['d'];
	$out['c'] = array();
	$temp = dateConvert($d, $t);
	list($d,$m,$y) = explode("-",$temp);
	$outDate = $y.$m.$d.$t;
	return $outDate;
}

function hYear($y = 0){
	$aYear = $y > 0 ? $y : intval(date("Y", time()));
	$hYear = round( ( $aYear - 621.03 ) / 0.97 );
	return $hYear;
}

function aYear($y){
	$aYear = round( ( 0.97 * $y ) + 621.03 );
	return $aYear;
}

function ageCalc($bd){
	$na   = date("Ymd")."A";
	$nh   = reverseDate($na);
	$t    = $bd[8];
	$td   = ( $t == "A" ) ? $na : $nh;
	$bd_p = outDate($bd);
	$td_p = outDate($td);
	
	if($bd > $td){
		$z = $td_p;
		$x = $bd_p; 
	}else{
		$z = $bd_p;
		$x = $td_p; 
	}
	
	if($x['d'] >= $z['d']){
		$d    = $x['d'] - $z['d'];
	}else{
		$x['m']--;
		$d    = $x['d'] + 30 - $z['d'];
	}
	
	if($x['m'] >= $z['m']){
		$m    = $x['m'] - $z['m'];
	}else{
		$x['y']--;
		$m    = $x['m'] + 12 - $z['m'];
	}

	$y 	= $x['y'] - $z['y'];
	
	$mx   = $m + ( $d / 30 );
	$age  = $y + ( $mx / 12 );
	
	$out  = array();
	$out['years'] = $y;
	$out['months'] = $m;
	$out['days'] = $d;
	$out['age'] = $age;
	$out['r_age'] = round($age);
	$out['in_months'] = round($age * 12);
	$out['in_days'] = round($age * 360);
	return $out;
}

function datesDif($from, $to){
	if( ( $from[8] != $to[8] ) ){
		$to = reverseDate($to);
	}
	if($to > $from){
		$t = outDate($to);
		$f = outDate($from);
		
		$tds = round($t['d']);
		$fds = round($f['d']);
		
		$tms = round($t['m']);
		$fms = round($f['m']);
		
		$tys = round($t['y']);
		$fys = round($f['y']);
		
		if($tds >= $fds){
			$ds = $tds - $fds + 1;
		}else{
			$tms--;
			$ds = 31 + $tds - $fds;
		}
		
		if($tms >= $fms){
			$ms = $tms - $fms;
		}else{
			$tys--;
			$ms = 12 + $tms - $fms;
		}
		
		$ys = $tys - $fys;
		
		$out = ( ( ( $ys * 12 ) + $ms ) * 30 ) + $ds;
		return $out;
	}
	return 0;	
}

function dateToTime($date){
	if($date[8] == "H") $ad = reverseDate($date);
	else $ad = $date;
	$dp = outDate($ad);
	$ds = round($dp['d']);
	$ms = round($dp['m']);
	$ys = round($dp['y']);
	$ts = mktime(0, 0, 1, $ms, $ds, $ys);
	return $ts;
}

function timeRound($time, $m = 60){
	$r = $time % ( $m * 60 );
	$x = $r / 60;
	$o = ( $x > ( $m / 2 ) ) ? ( $time + ( $m * 60 ) - $r ) : ( $time - $r );
	return $o;
}

function datePlusDays($date, $days){
	$ot = $date[8];
	$ts = dateToTime($date);
	$nt = $ts + ( $days * 24 * 60 * 60 );
	$ad = date("Ymd", $nt)."A";
	$hd = reverseDate($ad);
	if($ot == "H"){
		return $hd;
	}else{
		return $ad;
	}
}

function dayOfDate($date){
	if($date[8] != "A") $date = reverseDate($date);
	$d = outDate($date);
	$t = mktime(0, 0, 0, round($d['m']), round($d['d']), round($d['y']));
	return date("N", $t);
}

function dateConvert($date, $to = "A"){
	require_once("hijri.class");
	if(!isset($dateConv)){
		$dateConv = new Hijri_GregorianConvert;
	}
	$format = "YYYY/MM/DD";
	if($to == "H"){
		$out = $dateConv->GregorianToHijri($date,$format);	
	}else{
		$out = $dateConv->HijriToGregorian($date,$format);	
	}
	return $out;
}

function lastWorkDay($o = 0){
	$l = $o + 1;
	$sql = $GLOBALS['sql'];
	$today = date("Ymd")."A";
	$day = $sql->query("SELECT a.*, b.`week_day_name`, c.`ar_month_id`, d.`ar_month_name` FROM `plan_month_days` a, `week_days` b, `plan_months` c, `ar_months` d WHERE b.`week_day_id` = a.`week_day_id` AND c.`plan_month_id` = a.`plan_month_id` AND d.`ar_month_id` = c.`ar_month_id` AND `day_date` < '".$today."' AND `day_status` = 0 ORDER BY `day_id` DESC LIMIT ".$o.",1");
	if(count($day) > 0) return $day[0];
	else return false;
}

function innerDate($date){
	$sql = $GLOBALS['sql'];
	$day = $sql->query("SELECT a.`day_order`, b.`week_day_name`, c.`ar_month_id`, d.`ar_month_name`, e.`plan_end_date` FROM `plan_month_days` a, `week_days` b, `plan_months` c, `ar_months` d, `plans` e WHERE b.`week_day_id` = a.`week_day_id` AND c.`plan_month_id` = a.`plan_month_id` AND d.`ar_month_id` = c.`ar_month_id` AND e.`plan_id` = c.`plan_id` AND `day_date` LIKE '".$date."' ORDER BY `day_id` DESC LIMIT 1");
	if(count($day) > 0){
		$yyyy = substr($day[0]['plan_end_date'], 0, 4);
		$mm   = $day[0]['ar_month_id'] > 9 ? $day[0]['ar_month_id'] : '0'.$day[0]['ar_month_id'];
		$dd   = $day[0]['day_order'] > 9 ? $day[0]['day_order'] : '0'.$day[0]['day_order'];
		return $yyyy.$mm.$dd."H";
	}
	return revDate($date);
}

function aDate($hd){
	$sql = $GLOBALS['sql'];
	$hdp = outDate($hd);
	$hdy = round($hdp['y']);
	$hdm = round($hdp['m']);
	$hdd = round($hdp['d']);
	
	$pln = $sql->query("SELECT * FROM `plans` WHERE `plan_end_date` LIKE '".$hdy."1230H'");
	if(count($pln) > 0){
		$pln_id = $pln[0]['plan_id'];
		$mnth   = $sql->query("SELECT * FROM `plan_months` WHERE `plan_id` = ".$pln_id." AND `ar_month_id` = ".$hdm);
		if(count($mnth) > 0){
			$mnth_id = $mnth[0]['plan_month_id'];
			$day = $sql->query("SELECT * FROM `plan_month_days` WHERE `plan_month_id` = ".$mnth_id." AND `day_order` = ".$hdd);
			if(count($day) > 0){
				return $day[0]['day_date'];
			}
		}
	}
	return revDate($hd);
}

/////////////////////////// convert date to the system date///////////////

function sysDate($date){
	$prts = explode("-", $date);
	if($prts[0] >= 1900){
		$t = "A";
	}else{
		$t = "H";	
	}
	$yyyy = $prts[0];
	$mm = intval($prts[1]) > 9 ? intval($prts[1]) : '0'.intval($prts[1]);
	$dd = intval($prts[2]) > 9 ? intval($prts[2]) : '0'.intval($prts[2]);
	$out = $yyyy.$mm.$dd.$t;
	return $out;
}

function lastPlanDate(){
	$sql = $GLOBALS['sql'];
	$day = $sql->query("SELECT a.`day_order`, b.`week_day_name`, c.`ar_month_id`, d.`ar_month_name`, e.`plan_end_date` FROM `plan_month_days` a, `week_days` b, `plan_months` c, `ar_months` d, `plans` e WHERE b.`week_day_id` = a.`week_day_id` AND c.`plan_month_id` = a.`plan_month_id` AND d.`ar_month_id` = c.`ar_month_id` AND e.`plan_id` = c.`plan_id` ORDER BY `day_id` DESC LIMIT 1");
	if(count($day) > 0){
		$yyyy = substr($day[0]['plan_end_date'], 0, 4);
		$mm   = $day[0]['ar_month_id'] > 9 ? $day[0]['ar_month_id'] : '0'.$day[0]['ar_month_id'];
		$dd   = $day[0]['day_order'] > 9 ? $day[0]['day_order'] : '0'.$day[0]['day_order'];
		return $yyyy.$mm.$dd."H";
	}
	return false;
}

function firstPlanDate(){
	$sql = $GLOBALS['sql'];
	$day = $sql->query("SELECT a.`day_order`, b.`week_day_name`, c.`ar_month_id`, d.`ar_month_name`, e.`plan_end_date` FROM `plan_month_days` a, `week_days` b, `plan_months` c, `ar_months` d, `plans` e WHERE b.`week_day_id` = a.`week_day_id` AND c.`plan_month_id` = a.`plan_month_id` AND d.`ar_month_id` = c.`ar_month_id` AND e.`plan_id` = c.`plan_id` ORDER BY `day_id` ASC LIMIT 1");
	if(count($day) > 0){
		$yyyy = substr($day[0]['plan_end_date'], 0, 4);
		$mm   = $day[0]['ar_month_id'] > 9 ? $day[0]['ar_month_id'] : '0'.$day[0]['ar_month_id'];
		$dd   = $day[0]['day_order'] > 9 ? $day[0]['day_order'] : '0'.$day[0]['day_order'];
		return $yyyy.$mm.$dd."H";
	}
	return false;
}

////////////////////////time calc.////////////////////////////////

function timeDiff($a, $b, $f = "a", $p = 5){ //$a default in_time, $b the in_time, $f flag (a after, b befor), $p time permissions in min
	list($ha, $ma) = split(":", $a);
	list($hb, $mb) = split(":", $b);
	$nam = ( round($ha) * 60 ) + round($ma);
	$nbm = ( round($hb) * 60 ) + round($mb);
	switch($f){
		case 'b':
			$diff = $nam - $nbm;
		break;
		case 'a':
		default:
			$diff = $nbm - $nam;
		break;
	}
	$out = $diff > $p ? $diff : 0;
	return $out;
}

function latesCalc($lates){
	$out = $lates > 60 ? $lates + 60 : 2 * $lates;
	return $out;
}

function totalLates($lates){
	$out = $lates > 60 ? $lates : 0;
	return $out;
}

function minsToHours($mins){
	return round( ( $mins / 60 ), 2 );
}

//////////////////////////absence calc.////////////////////

function absenceCalc($a){
	if($a > 6){
		$out = $a + 4;
	}elseif($a > 3){
		$out = $a + 2;
	}elseif($a > 0){
		$out = $a + 1;
	}else{
		$out = 0;	
	}
	
	return $out;
}

////////////////////////rolls need for page///////////////////////

function canSeePage($page_roll, $staff_rolls){
	if(is_array($page_roll)){
		foreach($page_roll as $pr){
			if(in_array($pr, $staff_rolls)){
				return true;
			}
		}
		return false;
	}else{
		if(in_array($page_roll, $staff_rolls)){
			return true;
		}else{
			return false;	
		}
	}
}

///////////////////fld//////////////////////
function Fld($tbl,$idf = "id",$id = 0,$fld){
	$sql = $GLOBALS['sql'];
	$sql->tbl = $tbl;
	$sql->cond = "`".$idf."` LIKE '".$id."'";
	$n = $sql->NumRows();	
	if($n > 0){	
		$sql->tbl = $tbl;
		$sql->cond = "`".$idf."` LIKE '".$id."'";
		$sql->lim = "0,1";
		$out = $sql->Sel();
		return $out[0][$fld];
	}else{
		return "";	
	}
}

////////////////////word cut//////////////////
function WordCut($str,$s,$n){
	$words = explode(" ",$str);
	
	$count = count($words);
	
	$tail  = ( $count > $n ) ? '...' : ''; 
	$i = $s - 1;
	$new = array();	
	for($i; $i <= $n; $i++){
		$new[] = $words[$i];
	}
	$out = implode(" ",$new);
	return $out.$tail;	
}

/////////////////////////// settings ///////////////
function getSettings(){
	$sql = $GLOBALS['sql'];
	$s = $sql->query("SELECT `org_title`, `org_email`, `org_mobile`, `org_recordsperpage`, `org_monthlyleaves`, `org_maxvacationsbalanc` FROM `general_settings` WHERE `id` = 321456");
	return $s[0];
}

/////////////////////////// archiving ///////////////
function toArchive($tbl, $idf, $ids){
	$sql = $GLOBALS['sql'];
	$res = $sql->query("SELECT * FROM `".$tbl."` WHERE `".$idf."` = ".$ids." LIMIT 1");
	$rcd = serialize($res[0]);
	if($sql->simple("INSERT INTO `archive` VALUES( '', ".time().", '".$tbl."', ".$ids.", '".$rcd."' )")) return true;
	return false;
}


///////////////////////////upload files////////////////////

function upload($name, $target, $type = "images"){
	if(isset($_FILES[$name])){
		$file = $_FILES[$name];
		$realFileName = $file['name'];
		$uploadedFile = $file['tmp_name'];
	    $realFileExt  = Ext($realFileName);
		$acceptedExts = VExts($type);
		if(in_array($realFileExt, $acceptedExts)){
			$newFileName = md5($realFileName."_".time()."_".rand()).".".$realFileExt;
			if(move_uploaded_file($uploadedFile, $target."/".$newFileName)){
				return $newFileName;
			}
		}
	}
	return NULL;
}



//////////////////// yes no function//////////////////////////////////////////

function yesNo($i){
	return $i > 0 ? "نعم" : "لا";
}

function yesNoNot($i){
	switch($i){
		case 1:
			return "نعم";
		break;
		case 0:
			return "لا";
		break;
		case -1:
		default:
			return " - ";
		break;
	}
}

///////////////////////////redirectors/////////////

/* 1. redirect only 'no message, no confirm' */
function Redir($url){
	?>
    <script type="text/javascript">
    window.location = '<?=$url?>';
    </script>
    <?php
}

/* 2. redirect with message 'with message, no confirm' */
function RedirWM($url,$mes){
	?>
    <script type="text/javascript">
	alert('<?=$mes?>');
    window.location = '<?=$url?>';
    </script>
    <?php
}
/* 3. redirect with confirm first 'with message and confirm' */
function RedirWC($url,$mes){
	?>
    <script type="text/javascript">
	var c = confirm("<?=$mes?>");
	if(c){
    	window.location = '<?=$url?>';
	}
    </script>
    <?php
}
/* 4. redirect with choice first 'with message and confirm' */
function RedirO($tUrl, $fUrl, $mes){
	?>
    <script type="text/javascript">
	var c = confirm("<?=$mes?>");
	if(c){
    	window.location = '<?=$tUrl?>';
	}else{
		window.location = '<?=$fUrl?>';
	}
    </script>
    <?php
}

///////////////////////end of global functions//////////////////////
function getCount($query){
	$sql = $GLOBALS['sql'];
	$res = $sql->query($query);
	$cnt = 0;
	foreach($res as $r){
		$cnt++;
	}
	return $cnt;
}

////////////////////////////////////////////////////////////////////
require_once("messages.php");
?>