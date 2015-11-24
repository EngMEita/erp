<!-- Page Content -->
<?php if(in_array($_SESSION['staff']['staff_id'], array(101, 105, 107, 128))){ ?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> بيانات أساسية &raquo; </div>
                    </div>
                    <div class="panel-body pn">
                        <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        	<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                            	<thead>
                                	<tr role="row">
                                    	<th>ر. الأساسي</th>
                                        <th>ر. اليوم</th>
                                        <th>ر. الساعة</th>
                                        <th>ب. الإنتقال</th>
                                        <th>ب. إنتقال يوم</th>
                                        <th>ب. السكن</th>
                                        <th>ب. السكن 6 شهور</th>
                                        <th>ب. سكن شهر</th>
                                        <th>ب. سكن يوم</th>
                                        <th>ب. ندرة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<tr role="row">
                                    	<td><?=$stPln['salary']?> ريال</td>
                                        <td><?=round($stPln['salary'] / 30, 2)?> ريال</td>
                                        <td><?=round($stPln['salary'] / 240, 2)?> ريال</td>
                                        <td><?=$stPln['transport']?> ريال</td>
                                        <td><?=round($stPln['transport'] / 30, 2)?> ريال</td>
                                        <td><?=$stPln['housing']?> ريال</td>
                                        <td><?=round($stPln['housing'] / 2, 2)?> ريال</td>
                                        <td><?=round($stPln['housing'] / 12, 2)?> ريال</td>
                                        <td><?=round($stPln['housing'] / 360, 2)?> ريال</td>
                                        <td><?=$stPln['worknature']?> ريال</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> بيان الراتب &raquo; </div>
                    </div>
                    <div class="panel-body pn">
                        <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        	<form method="post" action="index.php?c=hcp-timesheet&mid=<?=$mid?>&staff_id=<?=$staff_id?>&act=savemoneysheet" name="moneySheet" id="moneySheet">
                            <input type="hidden" name="id" value="<?=$moneysheet['id']?>" />
                            <input type="hidden" name="msh[last_update]" value="<?=time()?>" />
                        	<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                            	<thead>
                                	<tr role="row">
                                    	<th rowspan="3">&nbsp;</th>
                                    	<th rowspan="3">الأساسي</th>
                                        <th colspan="9">إستحقاقات</th>
                                        <th colspan="4">إستقطاعات</th>
                                    </tr>
                                    <tr role="row">
                                        <th colspan="6">بدلات</th>
                                        <th rowspan="2">إضافي</th>
                                        <th rowspan="2">أخرى</th>
                                        <th colspan="2">تأمينات</th>
                                        <th rowspan="2">تأخيرات</th>
                                        <th rowspan="2">سلف</th>
                                        <th rowspan="2">أخرى</th>
                                    </tr>
                                    <tr role="row">
                                        <th>انتقال</th>
                                        <th>سكن</th>
                                        <th>ندرة</th>
                                        <th>انتداب</th>
                                        <th>تكليف</th>
                                        <th>تميز</th>
                                        <th>المؤسسة</th>
                                        <th>الفرد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<tr>
                                    	<td>محسوبة: </td>
                                        <td><?=$stPln['salary']?></td>
                                        <td><?=round( $stPln['transport'] - ( intval( $sms['absence_real'] ) * ( $stPln['transport'] / 30 ) ) )?></td>
                                        <td><?=$mid % 6 == 0 ? $stPln['housing'] / 2 : 0?></td>
                                        <td><?=$stPln['worknature']?></td>
                                        <td> - </td>
                                        <td> - </td>
                                        <td> - </td>
                                        <td><?=round( $sms['extras_count'] * ( $stPln['salary'] / 240 ) )?></td>
                                        <td> - </td>
                                        <td><?=$stPln['iso']?></td>
                                        <td><?=$stPln['isp']?></td>
                                        <td><?=round( ( ( intval( $sms['delays_count'] ) / 480 ) + intval( $sms['absence_count'] ) + ( intval( $sms['half_days'] ) / 2 ) ) * ( $stPln['salary'] / 30 ) )?></td>
                                        <td> - </td>
                                        <td> - </td>
                                    </tr>
                                    <tr>
                                    	<td>مسجلة: </td>
                                        <td><input type="text" name="msh[basic]" id="msh_basic" value="<?=$moneysheet['basic']?>" size="3" placeholder="<?=$stPln['salary']?>" /></td>
                                        <td><input type="text" name="msh[badal_transport]" id="msh_badal_transport" value="<?=$moneysheet['badal_transport']?>" size="3" placeholder="<?=round( $stPln['transport'] - ( intval( $sms['absence_real'] ) * ( $stPln['transport'] / 30 ) ) )?>" /></td>
                                        <td><input type="text" name="msh[badal_housing]" id="msh_badal_housing" value="<?=$moneysheet['badal_housing']?>" size="3" placeholder="<?=$mid % 6 == 0 ? $stPln['housing'] / 2 : 0?>" /></td>
                                        <td><input type="text" name="msh[badal_worknature]" id="msh_badal_worknature" value="<?=$moneysheet['badal_worknature']?>" size="3" placeholder="<?=$stPln['worknature']?>" /></td>
                                        <td><input type="text" name="msh[badal_entedab]" id="msh_badal_entedab" value="<?=$moneysheet['badal_entedab']?>" size="3" placeholder="0" /></td>
                                        <td><input type="text" name="msh[badal_takleef]" id="msh_badal_takleef" value="<?=$moneysheet['badal_takleef']?>" size="3" placeholder="0" /></td>
                                        <td><input type="text" name="msh[badal_communication]" id="msh_badal_communication" value="<?=$moneysheet['badal_communication']?>" size="3" placeholder="0" /></td>
                                        <td><input type="text" name="msh[extras]" id="msh_extras" value="<?=$moneysheet['extras']?>" size="3" placeholder="<?=round( intval( $sms['extras_count'] ) * ( $stPln['salary'] / 240 ) )?>" /></td>
                                        <td><input type="text" name="msh[awards]" id="msh_awards" value="<?=$moneysheet['awards']?>" size="3" placeholder="0" /></td>
                                        <td><input type="text" name="msh[iso]" id="msh_iso" value="<?=$moneysheet['iso']?>" size="3" placeholder="<?=$stPln['iso']?>" /></td>
                                        <td><input type="text" name="msh[isp]" id="msh_isp" value="<?=$moneysheet['isp']?>" size="3" placeholder="<?=$stPln['isp']?>" /></td>
                                        <td><input type="text" name="msh[delays]" id="msh_delays" value="<?=$moneysheet['delays']?>" size="3" placeholder="<?=round( ( ( intval( $sms['delays_count'] ) / 480 ) + intval( $sms['absence_count'] ) + ( intval( $sms['half_days'] ) / 2 ) ) * ( $stPln['salary'] / 30 ) )?>" /></td>
                                        <td><input type="text" name="msh[loans]" id="msh_loans" value="<?=$moneysheet['loans']?>" size="3" placeholder="0" /></td>
                                        <td><input type="text" name="msh[discounts]" id="msh_discounts" value="<?=$moneysheet['discounts']?>" size="3" placeholder="0" /></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                	<tr>
                                    	<td>ملاحظات: </td>
                                        <td colspan="7"><input type="text" value="<?=$moneysheet['comment']?>" name="msh[comment]" id="msh_comment" style="width:90%;" /></td>
                                        <td><input type="submit" name="save" value="حفظ" /></td>
                                        <td colspan="6">
                                        	<?php if($moneysheet['last_update'] > 0){ ?>
                                            ( اخر تحديث في <?=formatDate( innerDate( date("Ymd", $moneysheet['last_update'])."A" ), "yyyy/mm/dd T" )?> )
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
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<?php } ?>
<!-- /#page-wrapper -->