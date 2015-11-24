<h3><a name="family"></a>العائلة &raquo; </h3>
<table class="table no-footer">
    <thead>
    	<tr role="row">
        	<th>الاسم</th>
            <th>الصلة</th>
            <th>الجنسية</th>
            <th>التواجد</th>
            <th>بتاريخ</th>
            <th>العمر</th>
            <th>الهوية</th>
            <th>الإنتهاء</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($family as $f){ ?>
        	<?php if(isset($_GET['mod']) && $_GET['mod'] == "family" && isset($_GET['edit']) && $_GET['edit'] == $f['id']){ ?>
            <form action="index.php?c=profile&staff_id=<?=$staff_id?>" method="post">
            <input type="hidden" name="id" value="<?=$f['id']?>" />
            <input type="hidden" name="mod" value="family" />
            <input type="hidden" name="act" value="edit" />
            <tr role="row">
            	<td><a name="family_<?=$f['id']?>"></a><input type="text" name="fullname" value="<?=$f['fullname']?>" size="30" /></td>
                <td>
                	<select name="relationship" size="1">
                    	<option value="1.0"<?php if($f['gender'] == 1 && $f['relationship'] == 0){ ?> selected="selected"<?php } ?>><?=familyRelation(0, 1)?></option>
                        <option value="0.0"<?php if($f['gender'] == 0 && $f['relationship'] == 0){ ?> selected="selected"<?php } ?>><?=familyRelation(0, 0)?></option>
                        <option value="0.1"<?php if($f['gender'] == 0 && $f['relationship'] == 1){ ?> selected="selected"<?php } ?>><?=familyRelation(1, 0)?></option>
                        <option value="1.1"<?php if($f['gender'] == 1 && $f['relationship'] == 1){ ?> selected="selected"<?php } ?>><?=familyRelation(1, 1)?></option>
                        <option value="0.2"<?php if($f['gender'] == 0 && $f['relationship'] == 2){ ?> selected="selected"<?php } ?>><?=familyRelation(2, 0)?></option>
                        <option value="1.2"<?php if($f['gender'] == 1 && $f['relationship'] == 2){ ?> selected="selected"<?php } ?>><?=familyRelation(2, 1)?></option>
                    </select>
                </td>
                <td>
                	<select name="country_id" size="1">
                    	<?php foreach($countries as $d){ ?>
                        <option value="<?=$d['country_id']?>"<?php if($f['country_id'] == $d['country_id']){ ?> selected="selected"<?php } ?>><?=$d['country_nationality']?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                	<select name="comming_type" size="1">
                    	<option value="0"<?php if($f['comming_type'] == 0){ ?> selected="selected"<?php } ?>><?=familyComming(0)?></option>
                        <option value="1"<?php if($f['comming_type'] == 1){ ?> selected="selected"<?php } ?>><?=familyComming(1)?></option>
                        <option value="2"<?php if($f['comming_type'] == 2){ ?> selected="selected"<?php } ?>><?=familyComming(2)?></option>
                        <option value="3"<?php if($f['comming_type'] == 4){ ?> selected="selected"<?php } ?>><?=familyComming(3)?></option>
                    </select>
                </td>
                <td><input type="text" name="comming_date" value="<?=formatDate($f['comming_date'], "yyyy-mm-dd")?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td><input type="text" name="birthdate" value="<?=formatDate($f['birthdate'], "yyyy-mm-dd")?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td><input type="text" name="ssid" value="<?=$f['ssid']?>" size="8" /></td>
                <td><input type="text" name="ssid_ex_date" value="<?=formatDate($f['ssid_ex_date'], "yyyy-mm-dd")?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td>
                	<input type="submit" name="save" value="حفظ" />
                </td>
            </tr>
            </form>	
            <?php }else{ ?>
        	<tr role="row">
            	<td><a href="index.php?c=profile&staff_id=<?=$staff_id?>&mod=family&edit=<?=$f['id']?>#family_<?=$f['id']?>"><?=$f['fullname']?></a></td>
                <td><?=familyRelation($f['relationship'], $f['gender'])?></td>
                <td><?=Fld("countries", "country_id", $f['country_id'], "country_nationality")?><?=$f['gender'] > 0 ? "ة" : ""?></td>
                <td><?=familyComming($f['comming_type'])?></td>
                <td><?=formatDate($f['comming_date'], "yyyy-mm-dd")?></td>
                <td><span title="<?=formatDate($f['birthdate'], "dd MM yyyy")?>"><?=ageCalc($f['birthdate'])['r_age']?> سنة</span></td>
                <td><?=$f['ssid']?></td>
                <td><?=formatDate($f['ssid_ex_date'], "yyyy-mm-dd")?></td>
                <td>
                	<input type="button" name="delete" value="حذف -" onclick="confDelete('index.php?c=profile&staff_id=<?=$staff_id?>&mod=family&delete=<?=$f['id']?>');" />
                </td>
            </tr>
            <?php } ?>
        <?php } ?>
        <?php if(!isset($_GET['mod']) || $_GET['mod'] != "family" || !isset($_GET['edit'])){ ?>
        <form action="index.php?c=profile&staff_id=<?=$staff_id?>" method="post">
            <input type="hidden" name="staff_id" value="<?=$staff_id?>" />
            <input type="hidden" name="mod" value="family" />
            <input type="hidden" name="act" value="add" />
            <tr role="row">
            	<td><input type="text" name="fullname" value="" size="20" required="required" /></a></td>
                <td>
                	<select name="relationship" size="1">
                    	<option value="1.0"><?=familyRelation(0, 1)?></option>
                        <option value="0.0"><?=familyRelation(0, 0)?></option>
                        <option value="0.1"><?=familyRelation(1, 0)?></option>
                        <option value="1.1"><?=familyRelation(1, 1)?></option>
                        <option value="0.2"><?=familyRelation(2, 0)?></option>
                        <option value="1.2"><?=familyRelation(2, 1)?></option>
                    </select>
                </td>
                <td>
                	<select name="country_id" size="1">
                    	<?php foreach($countries as $d){ ?>
                        <option value="<?=$d['country_id']?>"><?=$d['country_nationality']?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                	<select name="comming_type" size="1">
                    	<option value="0"><?=familyComming(0)?></option>
                        <option value="1"><?=familyComming(1)?></option>
                        <option value="2" selected="selected"><?=familyComming(2)?></option>
                        <option value="3"><?=familyComming(3)?></option>
                    </select>
                </td>
                <td><input type="text" name="comming_date" value="" placeholder="1436-01-01" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td><input type="text" name="birthdate" value="" placeholder="1436-01-01" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td><input type="text" name="ssid" value="" required="required" size="8" /></td>
                <td><input type="text" name="ssid_ex_date" value="" placeholder="1436-01-01" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td>
                	<input type="submit" name="save" value="حفظ" />
                </td>
            </tr>
            </form>
            <?php } ?>
    </tbody>
</table>