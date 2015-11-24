		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> تحرير إجازة <?=$vacation_type['vacation_type_title']?> #<?=intval($_GET['vac_id'])?> &raquo; </div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=vacops&op=save" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="vac_id" value="<?=intval($_GET['vac_id'])?>" />
                                    <input type="hidden" name="c" value="hcp" />
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<tbody>
                                        	<tr role="row">
                                            	<td align="left"><strong>الموظف</strong>: </td>
                                                <td align="right"><?=Fld("staff", "staff_id", $vac['staff_id'], "staff_fullname")?><?php if($vacation_type['vacation_type_from_balance'] > 0){ ?> ( الرصيد المتاح <?=$vac['vacation_balance']?> يوم )<?php } ?></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>تاريخ الإجازة</strong>: </td>
                                                <?php if(canSeePage("ccp", $_SESSION['staff']['rolls']) || canSeePage("hcp", $_SESSION['staff']['rolls'])){ ?>
                                                <td align="right">
                                                	<input type="text" name="v[vacation_startdate]" value="<?=formatDate(innerDate($vac['vacation_startdate']), "yyyy-mm-dd")?>" placeholder="1980-01-01" size="10" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" id="vacStartDate" />
                                                    <span id="day_name"></span>
                                                    <script type="text/javascript">
														$(document).ready(function(){
                                                            var dt = $("#vacStartDate").val();
															$("#day_name").load("<?=$baseUrl?>index.php?c=dayname&dt=" + dt);
                                                        });
														$("#vacStartDate").keyup(function(){
															var dt = $("#vacStartDate").val();
															$("#day_name").load("<?=$baseUrl?>index.php?c=dayname&dt=" + dt);
														}); 
													</script>
                                             	</td>
                                                <?php }else{ ?>
                                                <td align="right"><?=Fld("week_days", "week_day_id", dayOfDate($vac['vacation_startdate']), "week_day_name")?>, <?=formatDate(innerDate($vac['vacation_startdate']), "dd-mm-yyyy T")?> الموافق <?=formatDate($vac['vacation_startdate'], "dd-mm-yyyy T")?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>مدة الإجازة</strong>: </td>
                                                <?php if(canSeePage("ccp", $_SESSION['staff']['rolls']) || canSeePage("hcp", $_SESSION['staff']['rolls'])){ ?>
                                                <td align="right">
                                                	<input type="text" name="v[vacation_duration]" value="<?=$vac['vacation_duration']?>" size="3" required> يوم
                                                </td>
                                                <?php }else{ ?>
                                                <td align="right"><?=$vac['vacation_duration']?> يوم</td>
                                                <?php } ?>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>الجوال المتاح</strong>: </td>
                                                <td align="right"><input type="text" name="v[vacation_mobile]" value="<?=$vac['vacation_mobile']?>" size="20" required></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>العنوان</strong>: </td>
                                                <td align="right"><textarea name="v[vacation_address]" cols="30" rows="3" required="required"><?=$vac['vacation_address']?></textarea></td>
                                            </tr>
                                            <?php if($vacation_type['vacation_type_need_resone'] > 0){ ?>
                                            <tr role="row">
                                            	<td align="left"><strong>السبب</strong>: </td>
                                                <td align="right"><textarea name="v[vacation_resone]" cols="30" rows="3" required="required" class="rte"><?=$vac['vacation_resone']?></textarea></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($vacation_type['vacation_type_need_attachment'] > 0){ ?>
                                            <tr role="row">
                                            	<td align="left"><strong>المرفق</strong>: </td>
                                                <td align="right" colspan="3"><input type="hidden" name="v['vacation_attachment']" value="<?=$vac['vacation_attachment']?>" /><input type="file" name="vacation_attachment" size="30" /></td>
                                            </tr>
                                            <?php } ?>
                                        	<tr role="row">
                                                <td colspan="2" align="center"><input type="submit" name="save" value="حفظ" /></td>
                                            </tr>
                        				</tbody>
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