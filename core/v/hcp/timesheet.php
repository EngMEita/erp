<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> <a href="index.php?c=hcp-plans">الخطط</a> &raquo; حضور وإنصراف شهر <?=$month['ar_month_name']?> من <?=$month['plan_title']?> ( <?=$ddMenu?> ) &raquo; </div>
                    </div>
                    <div class="panel-body pn">
                    	<a name="timesheet"></a>
                        <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>                        
                    	<form name="staffPlans" action="index.php?c=hcp-timesheet&mid=<?=$mid?><?=$pst?>&act=save" method="post">
                        <?php } ?>
                        <table class="table no-footer" id="DTable" data-order='[[ 1, "asc" ]]' data-page-length='100'>
                            <thead>
                                <tr role="row">
                                    <th>م.</th>
                                    <?php if(!isset($staff_id)){ ?><th>الاسم</th><?php } ?>
                                    <?php if(!isset($day_id)){ ?><th>اليوم</th><?php } ?>
                                    <th>الدوام</th>
                                    <th>حضور</th>
                                    <th>إنصراف</th>
                                    <th data-orderable="false">أخرى</th>
                                    <th data-orderable="false">ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$i = 1;
							$fts = $tss[0]['shift_id'];
                            foreach($tss as $ts){
                                ?>
                                <tr role="row"<?=colorStatus(intval($ts['status']))?>>
                                    <td data-order="<?=$i?>"><?=$i?><input type="hidden" name="ids[]" value="<?=$ts['id']?>"></td>
                                    <?php if(!isset($staff_id)){ ?>
                                    <td><a href="index.php?c=hcp-timesheet&mid=<?=$mid?>&staff_id=<?=$ts['staff_id']?>"><?=$ts['staff_fullname']?></a></td>
									<?php } ?>
                                    <?php if(!isset($day_id)){ ?>
                                    <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                                    <td data-order="<?=$ts['day_date']?>"><a href="index.php?c=hcp-timesheet&mid=<?=$mid?>&day_id=<?=$ts['day_id']?>"><?=$ts['week_day_name']?>, <?=$ts['day_order']?> <?=$month['ar_month_name']?> ( <?=formatDate($ts['day_date'], "dd-mm-yyyy")?> )</a></td>
                                    <?php }else{ ?>
                                     <td data-order="<?=$ts['day_date']?>"><?=$ts['day_order']?> <?=$month['ar_month_name']?> ( <?=formatDate($ts['day_date'], "dd-mm-yyyy")?> )</td>
                                    <?php } ?>
									<?php } ?>
                                    <td data-order="<?=$ts['shift_id']?>"><?=$ts['shift_title']?></td>
                                    <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                                    <td data-order="<?=$ts['in_time']?>"><input type="text" name="in[<?=$ts['id']?>]" value="<?=$ts['in_time']?>" size="5"<?php if(timeDiff($shs[$ts['shift_id']]['in'], $ts['in_time'], "a", 5) > 0){ ?> style="background-color:#F96;" title="تأخيرات <?=timeDiff($shs[$ts['shift_id']]['in'], $ts['in_time'], "a", 5)?> دقيقة"<?php } ?>></td>
                                    <td data-order="<?=$ts['out_time']?>"><input type="text" name="out[<?=$ts['id']?>]" value="<?=$ts['out_time']?>" size="5"<?php if(timeDiff($shs[$ts['shift_id']]['out'], $ts['out_time'], "b", 0) > 0){ ?> style="background-color:#F96;" title="تأخيرات <?=timeDiff($shs[$ts['shift_id']]['out'], $ts['out_time'], "b", 0)?> دقيقة"<?php } ?>></td>
                                    <td>
                                    	<select name="status[<?=$ts['id']?>]" size="1">
                                        	<option value="0"<?php if($ts['status'] == 0){ ?> selected<?php } ?>>يوم عمل</option>
                                            <option value="1"<?php if($ts['status'] == 1){ ?> selected<?php } ?>>إجازة أسبوعية</option>
                                            <option value="2"<?php if($ts['status'] == 2){ ?> selected<?php } ?>>إجازة رسمية</option>
                                            <option value="3"<?php if($ts['status'] == 3){ ?> selected<?php } ?>>استئذان</option>
                                            <option value="4"<?php if($ts['status'] == 4){ ?> selected<?php } ?>>إجازة</option>
                                            <option value="5"<?php if($ts['status'] == 5){ ?> selected<?php } ?>>نصف يوم</option>
                                            <option value="6"<?php if($ts['status'] == 6){ ?> selected<?php } ?>>غياب</option>
                                            <option value="7"<?php if($ts['status'] == 7){ ?> selected<?php } ?>>إجازة بدون راتب</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="comment[<?=$ts['id']?>]" value="<?=$ts['comment']?>" size="30" /></td>
                                    <?php }else{ ?>
                                    <td data-order="<?=$ts['in_time']?>"><input type="text" name="in[<?=$ts['id']?>]" value="<?=$ts['in_time']?>" size="5"<?php if(timeDiff($shs[$ts['shift_id']]['in'], $ts['in_time'], "a", 5) > 0){ ?> style="background-color:#F96;" title="تأخيرات <?=timeDiff($shs[$ts['shift_id']]['in'], $ts['in_time'], "a", 5)?> دقيقة"<?php } ?> disabled="disabled"></td>
                                    <td data-order="<?=$ts['out_time']?>"><input type="text" name="out[<?=$ts['id']?>]" value="<?=$ts['out_time']?>" size="5"<?php if(timeDiff($shs[$ts['shift_id']]['out'], $ts['out_time'], "b", 0) > 0){ ?> style="background-color:#F96;" title="تأخيرات <?=timeDiff($shs[$ts['shift_id']]['out'], $ts['out_time'], "b", 0)?> دقيقة"<?php } ?> disabled="disabled"></td>
                                    <td>
                                    	<select name="status[<?=$ts['id']?>]" size="1" disabled="disabled">
                                        	<option value="0"<?php if($ts['status'] == 0){ ?> selected<?php } ?>>يوم عمل</option>
                                            <option value="1"<?php if($ts['status'] == 1){ ?> selected<?php } ?>>إجازة أسبوعية</option>
                                            <option value="2"<?php if($ts['status'] == 2){ ?> selected<?php } ?>>إجازة رسمية</option>
                                            <option value="3"<?php if($ts['status'] == 3){ ?> selected<?php } ?>>استئذان</option>
                                            <option value="4"<?php if($ts['status'] == 4){ ?> selected<?php } ?>>إجازة</option>
                                            <option value="5"<?php if($ts['status'] == 5){ ?> selected<?php } ?>>نصف يوم</option>
                                            <option value="6"<?php if($ts['status'] == 6){ ?> selected<?php } ?>>غياب</option>
                                            <option value="7"<?php if($ts['status'] == 7){ ?> selected<?php } ?>>إجازة بدون راتب</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="comment[<?=$ts['id']?>]" value="<?=$ts['comment']?>" size="30" disabled="disabled" /></td>
                                    <?php } ?>
                                </tr>
                                <?php
								if(isset($staff_id)){
									if(isset($dr, $dc)){
										$dr += timeDiff($shs[$ts['shift_id']]['in'], $ts['in_time'], "a", 5);
										$dr += timeDiff($shs[$ts['shift_id']]['out'], $ts['out_time'], "b", 0);
										
										$dc += ( $ts['shift_id'] == $fts ) ? latesCalc(timeDiff($shs[$ts['shift_id']]['in'], $ts['in_time'], "a", 5)) : timeDiff($shs[$ts['shift_id']]['in'], $ts['in_time'], "a", 5);
										$dc += timeDiff($shs[$ts['shift_id']]['out'], $ts['out_time'], "b", 0);
									}
									
									if(isset($hd)){
										if($ts['status'] == 5) $hd++;
									}
									
									if(isset($ar)){
										if($ts['status'] == 6) $ar++;
									}
									
									if(isset($ws)){
										if($ts['status'] == 7) $ws++;
									}
								}
								$i++;
                            }
							if(isset($staff_id, $ar, $ac)){
								$ac = absenceCalc($ar);
							}
							if(isset($ws)){
								$ar += $ws;
								$ac += $ws;	
							}
							if(isset($dc)){
								$dc = $dc > 60 ? $dc : 0;
							}
                            ?>
                            </tbody>
                            <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                            <tfoot>
                            	<tr>
                                	<td colspan="7" align="center"><input type="submit" name="save" value="حفظ" /></td>
                                </tr>
                            </tfoot>
                            <?php } ?>
                        </table>
                        <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>