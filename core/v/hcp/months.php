		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> <a href="index.php?c=hcp-plans">الخطط</a> &raquo; شهور <?=$plan['plan_title']?> &raquo; </div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=hcp-planmonths&plan_id=<?=$plan['plan_id']?>" method="post">
                                    <input type="hidden" name="act" value="change" />
                                    <input type="hidden" name="plan_id" value="<?=$plan['plan_id']?>" />
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <th>الشهر</th>
                                                <?php if($r == "fcp"){ ?>
                                                <th>الموظف</th>
                                                <?php }else{ ?>
                                                <th>تاريخ البدء</th>
                                                <th colspan="2">الحضور والإنصراف</th>
                                                <?php } ?>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										foreach($months as $m){
											$cls = ( $i%2 ) > 0 ? 'odd' : 'even';
											?>
                                            <tr role="row" class="<?=$cls?>">
                                            	<td><?=$i?></td>
                                                <?php if($r == "fcp"){ ?>
                                                <td>
                                                	<a href="index.php?c=fcp-moneysheet&mid=<?=$m['plan_month_id']?>" target="_blank">حسابات شهر <?=Fld("ar_months", "ar_month_id", $m['ar_month_id'], "ar_month_name")?></a>
                                                    <?php $cf = $rootPath."accounting/".$m['plan_month_id']."_accounting.html"; ?>
                                                    <?php $cfs = urlencode($cf); ?>
                                                    <?php if(file_exists($cf)){ ?>
                                                    <span style="display:block; width:auto; float:left;">
                                                    &nbsp;<a href="export.php?f=<?=$cfs?>&a=print" target="_blank"><span class="fa fa-print"></span></a>
                                                    &nbsp;<a href="export.php?f=<?=$cfs?>&a=excel" target="_blank"><span class="fa fa-file-excel-o"></span></a>
                                                    &nbsp;<a href="export.php?f=<?=$cfs?>&a=word" target="_blank"><span class="fa fa-file-word-o"></span></a>
                                                    &nbsp;<a href="export.php?f=<?=$cfs?>&a=pdf" target="_blank"><span class="fa fa-file-pdf-o"></span></a>
                                                    </span>
                                                    <?php } ?>
                                               	</td>
                                                <td><?=$m['staff']?></td>
                                                <?php }else{ ?>
                                                <td><a href="index.php?c=workshifts&mid=<?=$m['plan_month_id']?>&KeepThis=true&TB_iframe=true&height=450&width=600&modal=true" title="دوامات شهر <?=Fld("ar_months", "ar_month_id", $m['ar_month_id'], "ar_month_name")?>" class="thickbox"><?=Fld("ar_months", "ar_month_id", $m['ar_month_id'], "ar_month_name")?></a></td>
                                                <td><input type="text" name="months[<?=$m['plan_month_id']?>]" value="<?=formatDate($m['plan_month_start_date'], "yyyy-mm-dd")?>" size="8" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" placeholder="<?=formatDate($m['plan_month_start_date'], "yyyy-mm-dd")?>" /></td>
                                                <td><?=$m['staff']?></td>
                                                <td><?=$m['days']?></td>
                                                <?php } ?>
                                            </tr>
                                            <?php
											$i++;
										}
										?>
                        				</tbody>
                                        <?php if(!canSeePage('fcp', $_SESSION['staff']['rolls']) || $r == "hcp"){ ?>
                                        <tfoot>
                                        	<tr role="row">
                                                <td colspan="2"></td>
                                                <td><input type="submit" name="save" value="حفظ" /><input type="reset" name="cancel" value="إلغاء" /></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                        <?php } ?>
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