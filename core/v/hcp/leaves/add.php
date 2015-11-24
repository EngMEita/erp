		<?php
		if(isset($staff_id) && staffLeaveOrder($staff_id, $mid, "m") > 2 && !canSeePage("acp", $_SESSION['staff']['rolls']) && !canSeePage("ccp", $_SESSION['staff']['rolls']) && !canSeePage("hcp", $_SESSION['staff']['rolls']) && !canSeePage("dcp", $_SESSION['staff']['rolls']) && !canSeePage("fcp", $_SESSION['staff']['rolls'])){
			RedirWM("index.php?c=hcp-leaves", "هذا الإستئذان رقم ".staffLeaveOrder($staff_id, $mid, "m")." لك هذا الشهر لذلك يرجى مراجعة شؤون الموظفين!");
		}
		?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> طلب استئذان &raquo; </div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=hcp-leaves&act=save" method="post" enctype="multipart/form-data" id="addLeaveFRM">
                                    <input type="hidden" name="id" value="0" />
                                    <input type="hidden" name="l[leave_applydate]" value="<?=$tda?>" />
                                    <input type="hidden" name="l[leave_applytime]" value="<?=time()?>" />
                                    <input type="hidden" name="plan_id" value="<?=$pln['plan_id']?>" />
                                    <?php if(isset($staff_id)){ ?>
                                    <input type="hidden" name="l[staff_id]" value="<?=$staff_id?>" />
                                    <input type="hidden" name="l[leave_in_month_order]" value="<?=staffLeaveOrder($staff_id, $mid, "m")?>" />
                                    <input type="hidden" name="l[leave_in_year_order]" value="<?=staffLeaveOrder($staff_id, $pln['plan_id'], "p")?>" />
                                    <?php if(canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('fcp', $_SESSION['staff']['rolls']) || canSeePage('dcp', $_SESSION['staff']['rolls'])){ ?>
                                    <input type="hidden" name="l[leave_status]" value="1" />
                                    <?php }elseif(canSeePage('ccp', $_SESSION['staff']['rolls'])){ ?>
                                    <input type="hidden" name="l[leave_status]" value="2" />
                                    <?php }else{ ?>
                                    <input type="hidden" name="l[leave_status]" value="0" />
                                    <?php } ?>
                                    <?php }else{ ?>
                                    <input type="hidden" name="l[leave_status]" value="-1" />
                                    <?php } ?>
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<tbody>
                                        	<?php if(isset($staff)){ ?>
                                        	<tr role="row">
                                            	<td align="left"><strong>الموظف</strong>: </td>
                                                <td align="right">
                                                <select name="l[staff_id]" size="1">
                                                	<?php foreach($staff as $s){ ?>
                                                    <option value="<?=$s['staff_id']?>"<?php if($s['staff_id'] == $_SESSION['staff']['staff_id']){ ?> selected="selected"<?php } ?>><?=$s['staff_fullname']?> ( #<?=staffLeaveOrder($s['staff_id'], $mid, "m")?> في الشهر, #<?=staffLeaveOrder($s['staff_id'], $pln['plan_id'], "p")?> في السنة )</option> 
                                                    <?php } ?>
                                                </select>
                                                <input type="hidden" name="l[leave_in_month_order]" value="0" />
                                    			<input type="hidden" name="l[leave_in_year_order]" value="0" />
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <tr role="row">
                                            	<td align="left"><strong>التاريخ</strong>: </td>
                                                <td align="right">
                                                	<input type="text" name="l[leave_date]" value="<?=formatDate($tdh, "yyyy-mm-dd")?>" placeholder="<?=formatDate($tdh, "yyyy-mm-dd")?>" size="10" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"  id="leaveDate" />
                                                    <span id="day_name"></span>
                                                    <script type="text/javascript">
														$(document).ready(function(){
                                                            var dt = $("#leaveDate").val();
															$("#day_name").load("<?=$baseUrl?>index.php?c=dayname&dt=" + dt);
                                                        });
														$("#leaveDate").keyup(function(){
															var dt = $("#leaveDate").val();
															$("#day_name").load("<?=$baseUrl?>index.php?c=dayname&dt=" + dt);
														}); 
													</script>
                                                </td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>المدة</strong>: </td>
                                                <td align="right"><input type="text" name="l[leave_from_time]" value="<?=date( "H:i", timeRound( time(), 15 ) + ( 2 * 60 * 60 ) )?>" size="5" required pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="الوقت بنظام 24 ساعة"> - <input type="text" name="l[leave_to_time]" value="<?=date( "H:i", timeRound( time(), 15 ) + ( 4 * 60 * 60 ) )?>" size="5" required pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="الوقت بنظام 24 ساعة"></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>السبب</strong>: </td>
                                                <td align="right"><textarea name="l[leave_resone]" cols="30" rows="3" required="required"></textarea></td>
                                            </tr>
                                        	<tr role="row">
                                                <td colspan="2" align="center"><input type="submit" name="save" value="حفظ" /></td>
                                            </tr>
                        				</tbody>
                        			</table>
                                    </form>
                                    <script type="text/javascript">
									$("#addLeaveFRM").submit(function(event) {
									  alert("يرجى التأكد من الموافقة على الإذن بصورة نهائية قبل مغادرة المؤسسة كي لا يحتسب خروج بدون إذن!!");  
									  return;
									});
									</script>
                        
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