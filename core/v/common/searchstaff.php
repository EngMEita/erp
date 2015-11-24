<?php
foreach($staff as $s){
	?>
    <label for="<?=$fld?>_staff_<?=$s['staff_id']?>" class="staffLabel">&nbsp;<input id="<?=$fld?>_staff_<?=$s['staff_id']?>" type="checkbox" name="<?=$fld?>[]" value="<?=$s['staff_id']?>" checked />&nbsp;<?=$s['staff_fullname']?> (<?=$s['staff_shortname']?>)</label>
    <?php
}
?>