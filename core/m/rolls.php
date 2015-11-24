<?php
function addRolls($staff, array $rolls){
	$sql = $GLOBALS['sql'];
	if($sql->simple("DELETE FROM `staff_rolls` WHERE `staff_id` = ".$staff)){
		$ok = 0;
		$all = count($rolls);
		foreach($rolls as $roll){
			if($sql->simple("INSERT INTO `staff_rolls` VALUES ( '', ".$staff.", '".$roll."' )")) $ok++;
		}
		
		if($ok === $all){
			return true;
		}
		return false;
	}
	return false;
}
?>