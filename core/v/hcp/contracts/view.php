<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> عقد عمل <?=Fld("staff", "staff_id", $contract[0]['contract']['staff_id'], "staff_fullname")?> &raquo; </div>
                    </div>
                    <div class="panel-body pn">                        
                        <table class="table no-footer">
                            <tbody>
                                <tr>
                                	<td align="left"><strong>تاريخ التعاقد</strong>: </td>
                                    <td align="right"><?=formatDate($contract[0]['contract']['contract_date'], "yyyy-mm-dd")?> ( منذ <?=round(datesDif($contract[0]['contract']['contract_date'], $tdh) / 30)?> شهر )</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>الفترة التجريبية</strong>: </td>
                                    <td align="right"><?=$contract[0]['contract']['contract_test_duration']?> شهر ( تنتهي في <?=formatDate(datePlusDays($contract[0]['contract']['contract_date'], $contract[0]['contract']['contract_test_duration'] * 30), "dd-mm-yyyy")?> )</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>مدة العقد</strong>: </td>
                                    <td align="right"><?=$contract[0]['contract']['contract_duration']?> شهر ( تنتهي في <?=formatDate(datePlusDays($contract[0]['contract']['contract_date'], $contract[0]['contract']['contract_duration'] * 30), "dd-mm-yyyy")?> )</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>يجدد تلقائيا</strong>: </td>
                                    <td align="right"><?=yesNo($contract[0]['contract']['contract_renewable'])?></td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>نوع العقد</strong>: </td>
                                    <td align="right"><?=contractType($contract[0]['contract']['contract_type'])?></td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>تفاصيل العقد</strong>: </td>
                                    <td align="right"><?=$contract[0]['contract']['contract_details']?></td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>نسخة العقد</strong>: </td>
                                    <td align="right"><?php if($contract[0]['contract']['contract_image'] != ""){ ?>[ <a href="contracts/<?=$contract[0]['contract']['contract_image']?>" target="_blank">صورة العقد</a> ]<?php } ?></td>
                                </tr>
                                <?php if(!is_array($contract[0]['ending'])){ ?>
                                <tr>
                                	<td align="center" colspan="2"><strong>تجديد العقد</strong></td>
                                </tr>
                                <?php if(is_array($contract[0]['renews']) && count($contract[0]['renews']) > 0){ ?>
                                <?php $r = 1; ?>
                                <?php foreach($contract[0]['renews'] as $renew){ ?>
                                <tr>
                                	<td align="left"><strong>تجديد <?=$r?></strong>: </td>
                                    <td align="right">في <?=formatDate($renew['renew_date'], "dd-mm-yyyy")?> لمدة <?=$renew['renew_duration']?> شهر</td>
                                </tr>
                                <?php $r++; ?>
                                <?php } ?>
                                <?php } ?>
                                <tr>
                                	<td colspan="2">
                                    	<form action="index.php?c=hcp-contract" method="post" enctype="multipart/form-data">
                        				<input type="hidden" name="act" value="save" />
                        				<input type="hidden" name="tbl" value="staff_contract_renews" />
                        				<input type="hidden" name="idf" value="" />
                        				<input type="hidden" name="id" value="" />
                                        <input type="hidden" name="v[contract_id]" value="<?=$contract_id?>" />
                                        <table>
                                        	<tr>
                                            	<td align="left"><strong>بتاريخ</strong>: </td>
                                                <td align="right"><input type="text" name="v[renew_date]" value="<?=formatDate(datePlusDays($contract[0]['contract']['contract_date'], $contract[0]['contract']['contract_duration'] * 30), "yyyy-mm-dd")?>" placeholder="1430-01-01" size="10" required="required" pattern="14[0-9]{2}-[0-9]{2}-[0-9]{2}" /></td>
                                                <td align="left"><strong>لمدة</strong>: </td>
                                                <td align="right">
                                                <select name="v[renew_duration]" id="renew_duration" size="1">
													<?php for($cd = 1; $cd <= 10; $cd++){ ?>
                                                    <option value="<?=$cd*12?>"<?php if($cd == 1){ ?> selected<?php } ?>><?=$cd?> سنة</option>
                                                    <?php } ?>
                                                </select>
                                                </td>
                                                <td align="center"><input type="submit" name="add" value="حفظ" /></td>
                                            </tr>
                                        </table>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(is_array($contract[0]['ending'])){ ?>
                                <tr>
                                	<td align="left"><strong>إنتهاء التعاقد</strong>: </td>
                                	<td align="right"><?=endingType($contract[0]['ending']['ending_type'])?> في <?=formatDate($contract[0]['ending']['ending_date'], "dd MM yyyy")?></td>
                                </tr>
                                <?php $e = contractEnding( $contract_id ); ?>
                                <tr>
                                	<td align="left"><strong>أخر راتب أساسي</strong>: </td>
                                    <td align="right"><?=$e['basicSalary']?> ريال</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>أخر راتب شامل</strong>: </td>
                                    <td align="right"><?=$e['totalSalary']?> ريال</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>أيام العمل في أخر شهر</strong>: </td>
                                    <td align="right"><?=$e['monthWorkDays']?> يوم</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>راتب أخر شهر</strong>: </td>
                                    <td align="right"><?=$e['lastMonthSalary']?> ريال</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>رصيد الإجازات</strong>: </td>
                                    <td align="right"><?=$e['vacationsBalance']?> يوم</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>بدل رصيد الإجازات</strong>: </td>
                                    <td align="right"><?=$e['vacationsValue']?> ريال</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>مدة الخدمة</strong>: </td>
                                    <td align="right"><?=$e['serviceDuration']?> سنة</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>مكافأة نهاية الخدمة الكاملة</strong>: </td>
                                    <td align="right"><?=$e['totalBenefits']?> ريال</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>مكافأة نهاية الخدمة المستحقة</strong>: </td>
                                    <td align="right"><?=$e['staffBenefits']?> ريال</td>
                                </tr>
                                <tr>
                                	<td align="left"><strong>بدل السكن المستحق</strong>: </td>
                                    <td align="right"><?=$e['badalHousing']?> ريال</td>
                                </tr>
                                <tr>
                                	<td colspan="2" align="center">
                                	<?php if(is_null($contract[0]['ending']['get_all_benefits'])){ ?>
                                    <form action="index.php?c=hcp-contract" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="act" value="save" />
                                        <input type="hidden" name="tbl" value="staff_contract_ending" />
                                        <input type="hidden" name="idf" value="contrcat_id" />
                                        <input type="hidden" name="id" value="<?=$contract_id?>" />
                                        <input type="hidden" name="v[get_all_benefits]" value="<?=$_SESSION['staff']['staff_id']?>.<?=$tdh?>.<?=date("H:i")?>" />
                                        <input type="submit" name="tasleem" value="تسليم كافة المستحقات" />
                                    </form>
                                	<?php }else{ ?>
                                	<?php $prts = explode(".", $contract[0]['ending']['get_all_benefits']); ?>
										لقد قام "<?=Fld("staff", "staff_id", $prts[0], "staff_fullname")?>" بتسليمه كافة المستحقات يوم <?=formatDate($prts[1], "dd-mm-yyyy")?> الساعة <?=$prts[2]?>	
                                	<?php } ?>
                                	</td>
                                </tr>
                                <?php }else{ ?>
                                <tr>
                                	<td colspan="2" align="center"><strong>إنهاء تعاقد <?=Fld("staff", "staff_id", $contract[0]['contract']['staff_id'], "staff_fullname")?></strong></td>
                                </tr>
                                <tr>
                                	<td colspan="2">
                                    	<form action="index.php?c=hcp-contract" method="post" enctype="multipart/form-data">
                        				<input type="hidden" name="act" value="save" />
                        				<input type="hidden" name="tbl" value="staff_contract_ending" />
                        				<input type="hidden" name="idf" value="" />
                        				<input type="hidden" name="id" value="" />
                                        <input type="hidden" name="v[contrcat_id]" value="<?=$contract_id?>" />
                                        <table>
                                        	<tr>
                                            	<td align="left"><strong>بتاريخ</strong>: </td>
                                                <td align="right"><input type="text" name="v[ending_date]" value="<?=formatDate($tdh, "yyyy-mm-dd")?>" placeholder="1430-01-01" size="10" required="required" pattern="14[0-9]{2}-[0-9]{2}-[0-9]{2}" /></td>
                                                <td align="left"><strong>بسبب</strong>: </td>
                                                <td align="right">
                                                <select name="v[ending_type]" id="ending_type" size="1">
													<?php for($cd = 0; $cd <= 4; $cd++){ ?>
                                                    <option value="<?=$cd?>"<?php if($cd == 0){ ?> selected<?php } ?>><?=endingType($cd)?></option>
                                                    <?php } ?>
                                                </select>
                                                </td>
                                                <td align="center"><input type="submit" name="add" value="حفظ" /></td>
                                            </tr>
                                        </table>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>