<h3><a name="docs"></a>الوثائق والمستندات &raquo; </h3>
<table class="table no-footer">
    <thead>
    	<tr role="row">
        	<th>النوع</th>
            <th>الإصدار</th>
            <th>الإنتهاء</th>
            <th>العنوان</th>
            <th>التفاصيل</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($docs as $doc){ ?>
        	<?php if(isset($_GET['mod']) && $_GET['mod'] == "docs" && isset($_GET['edit']) && $_GET['edit'] == $doc['doc_id']){ ?>
            <form action="index.php?c=profile&staff_id=<?=$staff_id?>" method="post">
            <input type="hidden" name="id" value="<?=$doc['doc_id']?>" />
            <input type="hidden" name="mod" value="docs" />
            <input type="hidden" name="act" value="edit" />
            <tr role="row">
            	<td>
                	<a name="doc_<?=$doc['doc_id']?>"></a>
                    <select name="type" size="1">
                    	<option value="0"<?php if($doc['doc_type'] == 0){ ?> selected="selected"<?php } ?>><?=docType(0)?></option>
                        <option value="1"<?php if($doc['doc_type'] == 1){ ?> selected="selected"<?php } ?>><?=docType(1)?></option>
                        <option value="2"<?php if($doc['doc_type'] == 2){ ?> selected="selected"<?php } ?>><?=docType(2)?></option>
                        <option value="3"<?php if($doc['doc_type'] == 3){ ?> selected="selected"<?php } ?>><?=docType(3)?></option>
                    </select>
               	</td>
                <td><input type="text" name="sdate" value="<?=formatDate($doc['doc_start_date'], "yyyy-mm-dd")?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td><input type="text" name="edate" value="<?=formatDate($doc['doc_end_date'], "yyyy-mm-dd")?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td><input type="text" name="title" value="<?=$doc['doc_title']?>" size="25" /></td>
                <td><input type="text" name="details" value="<?=$doc['doc_details']?>" size="40" /></td>
                <td>
                	<input type="submit" name="save" value="حفظ" />
                </td>
            </tr>
            </form>	
            <?php }else{ ?>
        	<tr role="row">
            	<td><?=docType($doc['doc_type'])?></td>
                <td><?=formatDate($doc['doc_start_date'], "yyyy-mm-dd")?></td>
                <td><?=formatDate($doc['doc_end_date'], "yyyy-mm-dd")?></td>
                <td><a href="index.php?c=profile&staff_id=<?=$staff_id?>&mod=docs&edit=<?=$doc['doc_id']?>#doc_<?=$doc['doc_id']?>"><?=$doc['doc_title']?></a></td>
                <td><?=$doc['doc_details']?></td>
                <td>
                	<input type="button" name="delete" value="حذف -" onclick="confDelete('index.php?c=profile&staff_id=<?=$staff_id?>&mod=docs&delete=<?=$doc['doc_id']?>');" />
                </td>
            </tr>
            <?php } ?>
        <?php } ?>
        <?php if(!isset($_GET['mod']) || $_GET['mod'] != "docs" || !isset($_GET['edit'])){ ?>
        <form action="index.php?c=profile&staff_id=<?=$staff_id?>" method="post">
            <input type="hidden" name="staff_id" value="<?=$staff_id?>" />
            <input type="hidden" name="mod" value="docs" />
            <input type="hidden" name="act" value="add" />
            <tr role="row">
            	<td>
                    <select name="type" size="1">
                    	<option value="0"><?=docType(0)?></option>
                        <option value="1"><?=docType(1)?></option>
                        <option value="2"><?=docType(2)?></option>
                        <option value="3"><?=docType(3)?></option>
                    </select>
               	</td>
                <td><input type="text" name="sdate" value="" placeholder="1436-01-01" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td><input type="text" name="edate" value="" placeholder="1436-01-01" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                <td><input type="text" name="title" value="" required="required" size="25" /></td>
                <td><input type="text" name="details" value="" size="40" /></td>
                <td>
                	<input type="submit" name="save" value="حفظ" />
                </td>
            </tr>
            </form>
            <?php } ?>
    </tbody>
</table>