<?php if(in_array($_SESSION['staff']['staff_id'], array(101, 105, 107, 128))){ ?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> <a href="index.php?c=hcp-plans">الخطط</a> &raquo; <?=$plan['plan_title']?> للموظفين &raquo; </div>
                    </div>
                    <div class="panel-body pn">                        
                    	<form name="staffPlans" action="index.php?c=hcp-staffplans&plan_id=<?=$plan['plan_id']?>" method="post">
                        <input type="hidden" name="plan_id" value="<?=$plan['plan_id']?>" />
                        <input type="hidden" name="act" value="setStaffPlans" />
                        <table class="table no-footer" id="DTable" data-order='[[ 1, "asc" ]]' data-page-length='50'>
                            <thead>
                                <tr role="row">
                                    <th>م.</th>
                                    <th>الاسم</th>
                                    <th>الراتب</th>
                                    <th>ب. سكن</th>
                                    <th>ب. إنتقال</th>
                                    <th>ب. ندرة</th>
                                    <th>ت. فرد</th>
                                    <th>ت. مؤسسة</th>
                                    <?php if(canSeePage('fcp', $_SESSION['staff']['rolls'])){ ?>
                                    <th>الشامل</th>
                                    <?php }else{ ?>
                                    <th>ج. رصيد</th>
                                    <th>ج. سابق</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$i = 1;
							$slr = 0;
							$hsg = 0;
							$trn = 0;
							$wrk = 0;
							$iso = 0;
                            foreach($sps as $k => $sp){
                                ?>
                                <tr role="row">
                                    <td><?=$i?></td>
                                    <td><?=$sp['s']['staff_fullname']?><input type="hidden" name="ids[]" value="<?=$sp['p']['id']?>"></td>
                                    <td data-order="<?=$sp['p']['salary']?>"><input type="text" name="salary[<?=$sp['p']['id']?>]" value="<?=$sp['p']['salary']?>" size="5"></td>
                                    <td data-order="<?=$sp['p']['housing']?>"><input type="text" name="housing[<?=$sp['p']['id']?>]" value="<?=$sp['p']['housing']?>" size="5"></td>
                                    <td data-order="<?=$sp['p']['transport']?>"><input type="text" name="transport[<?=$sp['p']['id']?>]" value="<?=$sp['p']['transport']?>" size="5"></td>
                                    <td data-order="<?=$sp['p']['worknature']?>"><input type="text" name="worknature[<?=$sp['p']['id']?>]" value="<?=$sp['p']['worknature']?>" size="5"></td>
                                    <td data-order="<?=$sp['p']['isp']?>"><input type="text" name="isp[<?=$sp['p']['id']?>]" value="<?=$sp['p']['isp']?>" size="5"></td>
                                    <td data-order="<?=$sp['p']['iso']?>"><input type="text" name="iso[<?=$sp['p']['id']?>]" value="<?=$sp['p']['iso']?>" size="5"></td>
                                    <?php if(canSeePage('fcp', $_SESSION['staff']['rolls'])){ ?>
                                    <td>
										<?=number_format($sp['p']['salary'] + ( $sp['p']['housing'] / 12 ) + $sp['p']['transport'] + $sp['p']['worknature'] - $sp['p']['isp'], 2, '.', ',')?>
                                        <input type="hidden" name="vacations_balance[<?=$sp['p']['id']?>]" value="<?=$sp['p']['vacations_balance']?>">
                                        <input type="hidden" name="previous_balance[<?=$sp['p']['id']?>]" value="<?=$sp['p']['previous_balance']?>">
                                    </td>
                                    <?php }else{ ?>
                                    <td data-order="<?=$sp['p']['vacations_balance']?>"><input type="text" name="vacations_balance[<?=$sp['p']['id']?>]" value="<?=$sp['p']['vacations_balance']?>" size="2"></td>
                                    <td data-order="<?=$sp['p']['previous_balance']?>">
                                    	<input type="text" name="previous_balance[<?=$sp['p']['id']?>]" value="<?=$sp['p']['previous_balance']?>" size="2" id="rpvb_<?=$sp['p']['id']?>">
                                        <?php if(isset($pre)){ ?>
                                        <input type="hidden" name="cpvb_<?=$sp['p']['id']?>" id="cpvb_<?=$sp['p']['id']?>" value="<?=$pre[$k]?>" />
                                        <?php } ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php
								$slr += $sp['p']['salary'];
								$hsg += $sp['p']['housing'];
								$trn += $sp['p']['transport'];
								$wrk += $sp['p']['worknature'];
								$iso += $sp['p']['iso'];
								$i++;
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            	<tr>
                                	<td colspan="<?php if(canSeePage('fcp', $_SESSION['staff']['rolls'])){ ?>9<?php }else{ ?>10<?php } ?>" align="center">
                                    	<input type="submit" name="save" value="حفظ" />
                                        <?php if(canSeePage('fcp', $_SESSION['staff']['rolls'])){ ?>
                                        <br />[ إجمالي الرواتب <strong>( <?=number_format($slr*12, 2, '.', ',')?> )</strong> ريال سعودي فقط لاغير ]
                                        <br />[ إجمالي بدل السكن <strong>( <?=number_format($hsg, 2, '.', ',')?> )</strong> ريال سعودي فقط لاغير ]
                                        <br />[ إجمالي بدل الإنتقال <strong>( <?=number_format($trn*12, 2, '.', ',')?> )</strong> ريال سعودي فقط لاغير ]
                                        <br />[ إجمالي بدل الندرة <strong>( <?=number_format($wrk*12, 2, '.', ',')?> )</strong> ريال سعودي فقط لاغير ]
                                        <br />[ إجمالي التأمينات نصيب المؤسسة <strong>( <?=number_format($iso*12, 2, '.', ',')?> )</strong> ريال سعودي فقط لاغير ]
                                        <br />[ إجمالي الميزانية السنوية <strong>( <?=number_format(( ( $slr*12 ) + ( $hsg ) + ( $trn*12 ) + ( $wrk*12 ) + ( $iso*12 ) ), 2, '.', ',')?> )</strong> ريال سعودي فقط لاغير ]
                                        <?php } ?>
                                        <?php if(isset($pre) && !canSeePage('fcp', $_SESSION['staff']['rolls'])){ ?>
                                        <input type="button" name="load" value="تحميل الأرصدة السابقة" id="lpvb" />
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else{ ?>
<p align="center">هذه الصفحة مغلقة مؤقتا!</p>
<?php } ?>