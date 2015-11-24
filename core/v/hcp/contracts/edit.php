<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> تحرير عقد عمل <?=Fld("staff", "staff_id", $contract[0]['contract']['staff_id'], "staff_fullname")?> &raquo; </div>
                    </div>
                    <div class="panel-body pn"> 
                    	<form action="index.php?c=hcp-contract" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="act" value="save" />
                        <input type="hidden" name="tbl" value="staff_contracts" />
                        <input type="hidden" name="idf" value="contract_id" />
                        <input type="hidden" name="id" value="<?=$contract_id?>" />
                        <table class="table no-footer">
                            <tbody>
                                <tr>
                                	<td align="left"><strong>تاريخ التعاقد</strong>: </td>
                                    <td align="right"><input type="text" name="v[contract_date]" value="<?=formatDate($contract[0]['contract']['contract_date'], "yyyy-mm-dd")?>" placeholder="1430-01-01" size="10" required pattern="14[0-9]{2}-[0-9]{2}-[0-9]{2}" /></td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>الفترة التجريبية</strong>: </td>
                                    <td align="right">
                                    	<select name="v[contract_test_duration]" id="contract_test_duration" size="1">
                                        	<option value="0">لا توجد</option>
                                        	<?php for($td = 1; $td <= 12; $td++){ ?>
                                            <option value="<?=$td?>"<?php if($td == $contract[0]['contract']['contract_test_duration']){ ?> selected<?php } ?>><?=$td?> شهر</option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>مدة العقد</strong>: </td>
                                    <td align="right">
                                    	<select name="v[contract_duration]" id="contract_duration" size="1">
                                        	<?php for($cd = 1; $cd <= 10; $cd++){ ?>
                                            <option value="<?=$cd*12?>"<?php if($cd*12 == $contract[0]['contract']['contract_duration']){ ?> selected<?php } ?>><?=$cd?> سنة</option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>يجدد تلقائيا</strong>: </td>
                                    <td align="right">
                                    	<select name="v[contract_renewable]" id="contract_renewable" size="1">
                                        	<?php for($cd = 0; $cd <= 1; $cd++){ ?>
                                            <option value="<?=$cd?>"<?php if($cd == $contract[0]['contract']['contract_renewable']){ ?> selected<?php } ?>><?=yesNo($cd)?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>نوع العقد</strong>: </td>
                                    <td align="right">
                                    	<select name="v[contract_type]" id="contract_type" size="1">
                                        	<?php for($cd = 0; $cd <= 3; $cd++){ ?>
                                            <option value="<?=$cd?>"<?php if($cd == $contract[0]['contract']['contract_type']){ ?> selected<?php } ?>><?=contractType($cd)?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>تفاصيل العقد</strong>: </td>
                                    <td align="right"><textarea name="v[contract_details]" id="contract_details" cols="60" rows="10" class="rte"><?=$contract[0]['contract']['contract_details']?></textarea></td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>نسخة العقد</strong>: </td>
                                    <td align="right"><input type="hidden" name="v[contract_image]" value="<?=$contract[0]['contract']['contract_image']?>" /><input type="file" name="contract_image" id="contract_image" size="60" /></td>
                                </tr>
                                <tr>
                                	<td align="left"></td>
                                    <td align="right"><input type="submit" name="add" value="حفظ"></td>
                                </tr>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>