<?php
require_once($rootPath."core/m/global.php");
$now = round(date("H"));
$d = $now > 9 ? -2 : -1;
if(isset($_GET['dt']) && $_GET['dt'] != ""  && isset($_GET['max']) && intval($_GET['max']) > 0){
	$dateF = ( isset($_GET['df']) && $_GET['df'] != "" ) ? sysDate($_GET['df']) : date("Ymd")."A";
	$dateT = sysDate($_GET['dt']);
	$x     = datesDif($dateF, $dateT);
	for($i = 0; $i < $x; $i++){
		$y = datePlusDays($dateF, $i);
		$n = array(5, 6);
		if(!in_array(dayOfDate($y), $n)){
			$d++;
		}
	}
}else die("ليس لديك رصيد إجازات.");

if($d >= 5){
	$x = intval($_GET['max']) > 60 ? 60 : intval($_GET['max']);
	?>
    <select name="v[vacation_duration]" id="vac_dur" size="1">
		<?php for($i = 1; $i <= $x; $i++){ ?>
        <option value="<?=$i?>"><?=$i?> يوم</option>
        <?php } ?>
    </select>
    <?php
}elseif($d >= 3){
	$x = intval($_GET['max']) > 10 ? 10 : intval($_GET['max']);	
	?>
    <select name="v[vacation_duration]" id="vac_dur" size="1">
		<?php for($i = 1; $i <= $x; $i++){ ?>
        <option value="<?=$i?>"><?=$i?> يوم</option>
        <?php } ?>
    </select>
    <?php
}elseif($d >= 1){
	$x = intval($_GET['max']) > 3 ? 3 : intval($_GET['max']);	
	?>
    <select name="v[vacation_duration]" id="vac_dur" size="1">
		<?php for($i = 1; $i <= $x; $i++){ ?>
        <option value="<?=$i?>"><?=$i?> يوم</option>
        <?php } ?>
    </select>
    <?php
}else{
	$x = intval($_GET['max']) > 0 ? 0 : intval($_GET['max']);	
	?>
    <select name="v[vacation_duration]" id="vac_dur" size="1" disabled="disabled">
		<?php for($i = 1; $i <= $x; $i++){ ?>
        <option value="<?=$i?>"><?=$i?> يوم</option>
        <?php } ?>
    </select>
    <?php
}

echo " ( بعد ".$d." يوم عمل )";
?>