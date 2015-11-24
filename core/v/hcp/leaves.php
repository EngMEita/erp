<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> أذونات الموظفين <?php if(canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('acp', $_SESSION['staff']['rolls'])){ ?>( 
                        <select name="mList" id="mList" class="change" size="1">
                        <?php
						$i = 0;
						foreach($mths as $m){
							if($i == 0){
								?>
                                <option value="index.php?c=hcp-leaves"<?php if(!isset($_GET['mid'])){ ?> selected="selected"<?php } ?>>الشهر الحالي</option>
                                <?php
							}else{
								?>
                                <option value="index.php?c=hcp-leaves&mid=<?=$m['plan_month_id']?>"<?php if(isset($_GET['mid']) && intval($_GET['mid']) == $m['plan_month_id']){ ?> selected="selected"<?php } ?>>شهر <?=$m['ar_month_name']?> <?=preg_replace('/\D/', '', $m['plan_title'])?> هـ</option>
                                <?php
							}
							$i++;
						}
						?>
                        </select> 
                        ) <?php } ?>&raquo; </div>
                    </div>
                    <div class="panel-body pn">
                        <table class="table no-footer"<?php if(!isset($_GET['report'])){ ?> id="DTable" data-order='[[ 9, "asc" ], [ 5, "desc" ]]' data-page-length='50'<?php } ?>>
                            <thead>
                                <tr role="row">
                                    <th>م.</th>
                                    <th>الاسم</th>
                                    <th data-orderable="false">#ش</th>
                                    <th data-orderable="false">#س</th>
                                    <?php if(!isset($_GET['report'])){ ?>
                                    <th>التقديم</th>
                                    <?php }else{ ?>
                                    <th>التاريخ</th>
                                    <?php } ?>
                                    <th>التاريخ</th>
                                    <th data-orderable="false">من</th>
                                    <th data-orderable="false">إلى</th>
                                    <?php if(!isset($_GET['report'])){ ?>
                                    <th data-orderable="false">السبب</th>
                                    <th>الحالة</th>
                                    <th data-orderable="false">
                                    	<input type="button" value="جديد + " name="new" onclick="window.location = 'index.php?c=hcp-leaves&act=add';" />
                                  	</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$i = 1;
                            foreach($lvs as $l){
								setStaffLeaveDay($l['leave_id'], 3)
                                ?>
                                <tr role="row">
                                    <td><?=$i?></td>
                                    <td><?=Fld("staff", "staff_id", $l['staff_id'], "staff_fullname")?></td>
                                   	<td><?=$l['leave_in_month_order']?></td>
									<td><?=$l['leave_in_year_order']?></td>
                                    <?php if(!isset($_GET['report'])){ ?>
                                    <td data-order="<?=$l['leave_applydate']?>"><?=formatDate(innerDate($l['leave_applydate']), "yyyy/mm/dd")?></td>
                                    <?php }else{ ?>
                                    <td><?=formatDate($l['leave_date'], "yyyy/mm/dd")?></td>
                                    <?php } ?>
                                    <td data-order="<?=$l['leave_date']?>"><span title="<?=Fld("week_days", "week_day_id", dayOfDate($l['leave_date']), "week_day_name")?>, <?=formatDate($l['leave_date'], "yyyy/mm/dd")?>"><?=formatDate(innerDate($l['leave_date']), "yyyy/mm/dd")?></span></td>
                                    <td><?=$l['leave_from_time']?></td>
                                    <td><?=$l['leave_to_time']?></td>
                                    <?php if(!isset($_GET['report'])){ ?>
                                    <td><span title="سبب الإستئذان: <?=$l['leave_resone']?>"><?=WordCut($l['leave_resone'], 1, 2)?></span></td>
                                    <td data-order="<?=$l['leave_status']?>">
                                    	<?php if(canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls'])){ ?>
                                    	<select name="status" id="status_<?=$l['leave_id']?>" class="change" size="1">
                                        <?php for($s = -1; $s <= 2; $s++){ ?>
                                        	<option value="index.php?c=hcp-leaves&act=status&status=<?=$s?>&id=<?=$l['leave_id']?>"<?php if($l['leave_status'] == $s){ ?> selected<?php } ?>><?=leaveStatus($s)?></option>
                                        <?php } ?>
                                        </select>
                                        <?php }elseif(canSeePage('dcp', $_SESSION['staff']['rolls']) && $l['leave_status'] < 1 && $l['staff_id'] != $_SESSION['staff']['staff_id']){ ?>
                                        <select name="status" id="status_<?=$l['leave_id']?>" class="change" size="1"<?php if($l['leave_status'] >= 2){ ?> disabled<?php } ?>>
                                        <?php for($s = -1; $s <= 1; $s++){ ?>
                                        	<option value="index.php?c=hcp-leaves&act=status&status=<?=$s?>&id=<?=$l['leave_id']?>"<?php if($l['leave_status'] == $s){ ?> selected<?php } ?>><?=leaveStatus($s)?></option>
                                        <?php } ?>
                                        </select>
                                        <?php }else{ ?>
                                        <?=leaveStatus($l['leave_status'])?>
                                        <?php } ?>
                                    </td>
                                    <td>
                                    	<select name="ops" id="ops_<?=$l['leave_id']?>" class="change" size="1">
                                        	<option selected>-- إختر --</option>
                                            <?php if( ( $_SESSION['staff']['staff_id'] == $l['staff_id'] && $l['leave_status'] < 1 ) || canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) ){ ?>
                                            <option value="index.php?c=hcp-leaves&act=edit&id=<?=$l['leave_id']?>">تحرير</option>
                                            <?php } ?>
                                            <?php if( ( $_SESSION['staff']['staff_id'] == $l['staff_id'] && $l['leave_status'] < 1 ) || canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('hcp', $_SESSION['staff']['rolls']) ){ ?>
                                            <option value="index.php?c=hcp-leaves&act=delete&id=<?=$l['leave_id']?>">حذف</option>
                                            <?php } ?>
                                        </select>
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