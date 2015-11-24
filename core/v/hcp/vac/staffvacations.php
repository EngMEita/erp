<script type="text/javascript">
function vacut(vac_id){
	var c = confirm("هل تود التوقيع على هذه المباشرة؟!");
	if(c == true){
		window.location = "index.php?c=vacut&vac_id=" + vac_id + "&op=status";
	}
}
</script>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> إجازات الموظفين <?php if(canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('acp', $_SESSION['staff']['rolls'])){ ?>( 
                        <select name="mList" id="mList" class="change" size="1">
                        <?php
						$i = 0;
						foreach($mths as $m){
							if($i == 0){
								?>
                                <option value="index.php?c=hcp-staffvacations"<?php if(!isset($_GET['mid'])){ ?> selected="selected"<?php } ?>>الشهر الحالي</option>
                                <?php
							}else{
								?>
                                <option value="index.php?c=hcp-staffvacations&mid=<?=$m['plan_month_id']?>"<?php if(isset($_GET['mid']) && intval($_GET['mid']) == $m['plan_month_id']){ ?> selected="selected"<?php } ?>>شهر <?=$m['ar_month_name']?> <?=preg_replace('/\D/', '', $m['plan_title'])?> هـ</option>
                                <?php
							}
							$i++;
						}
						?>
                        </select> 
                        ) <?php } ?>&raquo; </div>
                    </div>
                    <div class="panel-body pn">
                        <table class="table no-footer"<?php if(!isset($_GET['report'])){ ?> id="DTable" data-order='[[ 7, "asc" ], [ 4, "desc" ]]' data-page-length='50'<?php } ?>>
                            <thead>
                                <tr role="row">
                                    <th>م.</th>
                                    <th>الاسم</th>
                                    <th>الإجازة</th>
                                    <?php if(!isset($_GET['report'])){ ?>
                                    <th>التقديم</th>
                                    <?php }else{ ?>
                                    <th>التاريخ</th>
                                    <?php } ?>
                                    <th>التاريخ</th>
                                    <th>الرصيد</th>
                                    <th>المدة</th>
                                    <?php if(!isset($_GET['report'])){ ?>
                                    <th>الحالة</th>
                                    <th data-orderable="false">المباشرة</th>
                                    <th data-orderable="false">
                                    	<select name="vacType" id="vacType" class="change" size="1">
                                        	<option selected="selected">جديد +</option>
                                            <?php foreach($typs as $t){ ?>
                                            <option value="index.php?c=vacops&op=add&vacation_type_id=<?=$t['vacation_type_id']?>"><?=$t['vacation_type_title']?></option>
                                            <?php } ?>
                                        </select>
                                  	</th>
                                    <?php }else{ ?>
                                    <th data-orderable="false">المباشرة</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$i = 1;
                            foreach($vacs as $v){
								setStaffVacDays($v['vacation_id'], 4);
                                ?>
                                <tr role="row">
                                    <td><?=$i?></td>
                                    <td><?=$v['staff_fullname']?></td>
                                    <td<?php if($v['vacation_resone'] != ""){ ?> title="<?=$v['vacation_resone']?>"<?php } ?>><?=$v['vacation_type_title']?><?php if($v['vacation_attachment'] != "" && !isset($_GET['report'])){ ?> [ <a target="_blank" href="vacs/<?=$v['vacation_attachment']?>"><i class="fa fa-paperclip"></i></a> ]<?php } ?></td>
                                    <?php if(!isset($_GET['report'])){ ?>
                                    <td data-order="<?=$v['vacation_applydate']?>"><?=formatDate(innerDate($v['vacation_applydate']), "yyyy/mm/dd")?></td>
                                    <?php }else { ?>
                                    <td><?=formatDate($v['vacation_startdate'], "yyyy/mm/dd")?></td>
                                    <?php } ?>
                                    <td data-order="<?=$v['vacation_startdate']?>"><span title="<?=Fld("week_days", "week_day_id", dayOfDate($v['vacation_startdate']), "week_day_name")?>, <?=formatDate($v['vacation_startdate'], "yyyy/mm/dd")?>"><?=formatDate(innerDate($v['vacation_startdate']), "yyyy/mm/dd")?></span></td>
                                    <?php if($v['vacation_balance'] > 0){ ?>
                                    <td data-order="<?=$v['vacation_balance']?>"><?=$v['vacation_balance']?> يوم</td>
                                    <?php }else{ ?>
                                    <td data-order="0"> - </td>
                                    <?php } ?>
                                    <td data-order="<?=$v['vacation_duration']?>"><?=$v['vacation_duration']?> يوم</td>
                                    <?php if(!isset($_GET['report'])){ ?>
                                    <td data-order="<?=$v['vacation_status']?>">
                                    	<?php if(canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls'])){ ?>
                                    	<select name="status" id="status_<?=$v['vacation_id']?>" class="change" size="1">
                                        <?php for($s = -1; $s <= 3; $s++){ ?>
                                        	<option value="index.php?c=vacops&op=status&status=<?=$s?>&vac_id=<?=$v['vacation_id']?>"<?php if($v['vacation_status'] == $s){ ?> selected<?php } ?>><?=vacStatus($s)?></option>
                                        <?php } ?>
                                        </select>
                                        <?php }elseif(canSeePage('dcp', $_SESSION['staff']['rolls']) && $v['vacation_status'] < 1){ ?>
                                        <select name="status" id="status_<?=$v['vacation_id']?>" class="change" size="1"<?php if($v['vacation_status'] >= 2){ ?> disabled<?php } ?>>
                                        <?php for($s = -1; $s <= 1; $s++){ ?>
                                        	<option value="index.php?c=vacops&op=status&status=<?=$s?>&vac_id=<?=$v['vacation_id']?>"<?php if($v['vacation_status'] == $s){ ?> selected<?php } ?>><?=vacStatus($s)?></option>
                                        <?php } ?>
                                        </select>
                                        <?php }else{ ?>
                                        <?=vacStatus($v['vacation_status'])?>
                                        <?php } ?>
                                    </td>
                                    <td align="center" style="text-align:center; alignment-adjust:central;<?php if(Fld("vacation_types", "vacation_type_id", $v['vacation_type_id'], "vacation_type_need_cut") < 1){ ?> background-color:#FF7E00;<?php } ?>">
                                    	<?php
										if(Fld("vacation_types", "vacation_type_id", $v['vacation_type_id'], "vacation_type_need_cut") < 1){
											echo "لا تحتاج";
										}elseif(!is_null($v['vacation_cut_date'])){
											if(canSeePage('ccp', $_SESSION['staff']['rolls'])){
												if(is_null($v['vacation_cut_ce_hash'])){
													?>
                                                    <input title="<?=Fld("week_days", "week_day_id", dayOfDate($v['vacation_cut_date']), "week_day_name")?>, <?=formatDate($v['vacation_cut_date'], "yyyy/mm/dd")?>" type="button" name="vacut" value="<?=formatDate(innerDate($v['vacation_cut_date']), "yyyy-mm-dd")?>" onclick="vacut(<?=$v['vacation_id']?>);" />
                                                    <?php	
												}else{
													echo formatDate(innerDate($v['vacation_cut_date']), "yyyy-mm-dd");		
												}
											}elseif(canSeePage('hcp', $_SESSION['staff']['rolls'])){
												if(is_null($v['vacation_cut_hr_hash'])){
													?>
                                                    <input title="<?=Fld("week_days", "week_day_id", dayOfDate($v['vacation_cut_date']), "week_day_name")?>, <?=formatDate($v['vacation_cut_date'], "yyyy/mm/dd")?>" type="button" name="vacut" value="<?=formatDate(innerDate($v['vacation_cut_date']), "yyyy-mm-dd")?>" onclick="vacut(<?=$v['vacation_id']?>);" />
                                                    <?php	
												}else{
													?>
													<span title="<?=Fld("week_days", "week_day_id", dayOfDate($v['vacation_cut_date']), "week_day_name")?>, <?=formatDate($v['vacation_cut_date'], "yyyy/mm/dd")?>"><?=formatDate(innerDate($v['vacation_cut_date']), "yyyy-mm-dd")?></span>
                                                    <?php
												}
											}elseif(canSeePage('dcp', $_SESSION['staff']['rolls'])){
												if(is_null($v['vacation_cut_dm_hash'])){
													?>
                                                    <input title="<?=Fld("week_days", "week_day_id", dayOfDate($v['vacation_cut_date']), "week_day_name")?>, <?=formatDate($v['vacation_cut_date'], "yyyy/mm/dd")?>" type="button" name="vacut" value="<?=formatDate(innerDate($v['vacation_cut_date']), "yyyy-mm-dd")?>" onclick="vacut(<?=$v['vacation_id']?>);" />
                                                    <?php	
												}else{
													?>
													<span title="<?=Fld("week_days", "week_day_id", dayOfDate($v['vacation_cut_date']), "week_day_name")?>, <?=formatDate($v['vacation_cut_date'], "yyyy/mm/dd")?>"><?=formatDate(innerDate($v['vacation_cut_date']), "yyyy-mm-dd")?></span>
                                                    <?php		
												}
											}else{
												?>
                                                <span title="<?=Fld("week_days", "week_day_id", dayOfDate($v['vacation_cut_date']), "week_day_name")?>, <?=formatDate($v['vacation_cut_date'], "yyyy/mm/dd")?>"><?=formatDate(innerDate($v['vacation_cut_date']), "yyyy-mm-dd")?></span>
                                                <?php
											}
										}else{
											echo " - ";	
										}
										?>
                                    </td>
                                    <td>
                                    	<select name="ops" id="ops_<?=$v['vacation_id']?>" class="change" size="1">
                                        	<option selected>-- إختر --</option>
                                            <?php if($v['vacation_status'] >= 2){ ?>
                                            <option value="index.php?c=vacops&op=print&vac_id=<?=$v['vacation_id']?>">طباعة</option>
                                            <?php } ?>
                                            <?php if( ($_SESSION['staff']['staff_id'] == $v['staff_id'] && $v['vacation_status'] < 1) || canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) ){ ?>
                                            <option value="index.php?c=vacops&op=edit&vac_id=<?=$v['vacation_id']?>">تحرير</option>
                                            <?php } ?>
                                            <?php if( ($_SESSION['staff']['staff_id'] == $v['staff_id'] && $v['vacation_status'] < 1) || canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) ){ ?>
                                            <option value="index.php?c=vacops&op=delete&vac_id=<?=$v['vacation_id']?>">حذف</option>
                                            <!-- <option value="index.php?c=vacops&op=status&status=-2&vac_id=<?=$v['vacation_id']?>">حذف</option> -->
                                            <?php } ?>
                                            <?php if( $_SESSION['staff']['staff_id'] == $v['staff_id'] && $v['vacation_status'] > 2 && Fld('vacation_types', 'vacation_type_id', $v['vacation_type_id'], 'vacation_type_need_cut') > 0 && $tda > $v['vacation_startdate'] && is_null($v['vacation_cut_date'])){ ?>
                                            <option value="index.php?c=vacut&vac_id=<?=$v['vacation_id']?>">مباشرة</option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <?php }else{ ?>
                                    <td>
                                    <?php
									if(Fld("vacation_types", "vacation_type_id", $v['vacation_type_id'], "vacation_type_need_cut") < 1){
										echo "لا تحتاج";
									}elseif(!is_null($v['vacation_cut_date'])){
										echo formatDate(innerDate($v['vacation_cut_date']), "yyyy-mm-dd");
									}else{
										echo " - ";
									}
									?>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php
								$i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>