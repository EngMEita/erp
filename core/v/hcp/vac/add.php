		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> طلب إجازة <?=$vacation_type['vacation_type_title']?> جديدة &raquo; </div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=vacops&op=save" method="post" enctype="multipart/form-data" id="addVacFRM">
                                    <input type="hidden" name="v[vacation_type_id]" value="<?=$vacation_type_id?>" />
                                    <input type="hidden" name="v[vacation_applydate]" value="<?=$tda?>" />
                                    <input type="hidden" name="v[vacation_applytime]" value="<?=time()?>" />
                                    <input type="hidden" name="plan_id" value="<?=$pln['plan_id']?>" />
                                    <?php if(isset($staff_id)){ ?>
                                    <input type="hidden" name="v[staff_id]" value="<?=$staff_id?>" />
                                    <input type="hidden" name="c" value="scp" />
                                    <?php if(canSeePage('hcp', $_SESSION['staff']['rolls']) || canSeePage('fcp', $_SESSION['staff']['rolls']) || canSeePage('dcp', $_SESSION['staff']['rolls'])){ ?>
                                    <input type="hidden" name="v[vacation_status]" value="1" />
                                    <?php }elseif(canSeePage('ccp', $_SESSION['staff']['rolls'])){ ?>
                                    <input type="hidden" name="v[vacation_status]" value="2" />
                                    <?php }else{ ?>
                                    <input type="hidden" name="v[vacation_status]" value="0" />
                                    <?php } ?>
                                    <?php }else{ ?>
                                    <input type="hidden" name="c" value="hcp" />
                                    <input type="hidden" name="v[vacation_status]" value="-1" />
                                    <?php } ?>
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<tbody>
                                        	<?php if(isset($staff)){ ?>
                                        	<tr role="row">
                                            	<td align="left"><strong>الموظف</strong>: </td>
                                                <td align="right">
                                                <select name="v[staff_id]" size="1" id="staff_list">
                                                	<?php foreach($staff as $s){ ?>
                                                    <option value="<?=$s['staff_id']?>"<?php if($s['staff_id'] == $_SESSION['staff']['staff_id']){ ?> selected="selected"<?php } ?>><?=$s['staff_fullname']?><?php if($vacation_type['vacation_type_from_balance'] > 0){ ?> ( الرصيد المتاح <?=staffBalance($s['staff_id'], $plan['plan_id'], $tdh)?> يوم )<?php } ?></option> 
                                                    <?php } ?>
                                                </select>
                                                <script type="text/javascript">
													$(document).ready(function(){
														var id = $("#staff_list").val();
														//$("#staff_mobile").load("<?=$baseUrl?>index.php?c=staffdata&fld=staff_mobile&id=" + id);
														$.get("<?=$baseUrl?>index.php?c=staffdata&fld=staff_mobile&id=" + id, function(mobile){
															$("#staff_mobile").val(mobile);
														})
														$("#staff_address").load("<?=$baseUrl?>index.php?c=staffdata&fld=staff_address&id=" + id);
													});
													$("#staff_list").on('change', function() {
														var id = $("#staff_list").val();
														$.get("<?=$baseUrl?>index.php?c=staffdata&fld=staff_mobile&id=" + id, function(mobile){
															$("#staff_mobile").val(mobile);
														})
														$("#staff_address").load("<?=$baseUrl?>index.php?c=staffdata&fld=staff_address&id=" + id);
													}); 
												</script>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <tr role="row">
                                            	<td align="left"><strong>تاريخ الإجازة</strong>: </td>
                                                <td align="right">
                                                	<input type="text" name="v[vacation_startdate]" value="<?=formatDate(datePlusDays($tdh, 7), "yyyy-mm-dd")?>" placeholder="1980-01-01" size="10" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" id="vacStartDate" />
                                                    <span id="day_name"></span>
                                                    <?php if($vacation_type['vacation_type_from_balance'] > 0 && isset($staff_id)){ ?>
                                                    <input type="hidden" name="maxDur" id="maxDurVal" value="<?=staffBalance($staff_id, $plan['plan_id'], $tdh)?>" />
                                                	<script type="text/javascript">
														$(document).ready(function(){
                                                            var dt = $("#vacStartDate").val();
															var mx = $("#maxDurVal").val();
															$("#durDiv").load("<?=$baseUrl?>index.php?c=maxvacdur&dt=" + dt + "&max=" + mx);
															$("#day_name").load("<?=$baseUrl?>index.php?c=dayname&dt=" + dt);
                                                        });
														$("#vacStartDate").keyup(function(){
															var dt = $("#vacStartDate").val();
															var mx = $("#maxDurVal").val();
															$("#durDiv").load("<?=$baseUrl?>index.php?c=maxvacdur&dt=" + dt + "&max=" + mx);
															$("#day_name").load("<?=$baseUrl?>index.php?c=dayname&dt=" + dt);
														}); 
													</script>
                                                    <?php }else{ ?>
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
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>مدة الإجازة</strong>: </td>
                                                <?php if($vacation_type['vacation_type_id'] == 12){ ?>
                                                <td align="right">
                                                	<input type="hidden" name="v[vacation_balance]" value="-1" />
                                                	<select name="v[vacation_duration]" id="vac_dur" size="1">
                                                        <option value="3">3 أيام ( للأصول والفروع )</option>
                                                        <option value="1">يوم واحد لغيرهم</option>
                                                    </select>
                                                </td>
                                                <?php }elseif($vacation_type['vacation_type_from_balance'] > 0 && isset($staff_id)){ ?>
                                                <td align="right">
                                                	<input type="hidden" name="v[vacation_balance]" value="<?=staffBalance($staff_id, $plan['plan_id'], $tdh)?>" />
                                                    <div id="durDiv">
                                                	<select name="v[vacation_duration]" id="vac_dur" size="1">
                                                    	<?php for($i = 1; $i <= staffBalance($staff_id, $plan['plan_id'], $tdh); $i++){ ?>
                                                        <option value="<?=$i?>"><?=$i?> يوم</option>
                                                        <?php } ?>
                                                    </select>
                                                    </div>
                                                </td>
                                                <?php }elseif($vacation_type['vacation_type_max_duration'] > 0){ ?>
                                                <td align="right">
                                                	<input type="hidden" name="v[vacation_balance]" value="-1" />
                                                	<select name="v[vacation_duration]" id="vac_dur" size="1">
                                                    	<?php for($i = 1; $i <= $vacation_type['vacation_type_max_duration']; $i++){ ?>
                                                        <option value="<?=$i?>"><?=$i?> يوم</option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <?php }else{ ?>
                                                <td align="right">
                                                	<input type="hidden" name="v[vacation_balance]" value="0" />
                                                	<input type="text" name="v[vacation_duration]" id="vac_dur" value="" size="3" required> يوم
                                                </td>
                                                <?php } ?>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>الجوال المتاح</strong>: </td>
                                                <?php if(isset($staff_id)){ ?>
                                                <td align="right"><input type="text" name="v[vacation_mobile]" value="<?=Fld("staff", "staff_id", $staff_id, "staff_mobile")?>" size="20" required></td>
                                                <?php }else{ ?>
                                                <td align="right"><input type="text" name="v[vacation_mobile]" value="" size="20" id="staff_mobile" required></td>
                                                <?php } ?>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>العنوان</strong>: </td>
                                                <?php if(isset($staff_id)){ ?>
                                                <td align="right"><textarea name="v[vacation_address]" cols="30" rows="3" required="required"><?=Fld("staff", "staff_id", $staff_id, "staff_address")?></textarea></td>
                                                <?php }else{ ?>
                                                <td align="right"><textarea name="v[vacation_address]" cols="30" rows="3" id="staff_address" required="required"></textarea></td>
                                                <?php } ?>
                                            </tr>
                                            <?php if($vacation_type['vacation_type_need_resone'] > 0){ ?>
                                            <tr role="row">
                                            	<td align="left"><strong>السبب</strong>: </td>
                                                <td align="right"><textarea name="v[vacation_resone]" cols="30" rows="3" required="required"></textarea></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($vacation_type['vacation_type_need_attachment'] > 0){ ?>
                                            <tr role="row">
                                            	<td align="left"><strong>المرفق</strong>: </td>
                                                <td align="right" colspan="3"><input type="file" name="vacation_attachment" size="30" /></td>
                                            </tr>
                                            <?php } ?>
                                        	<tr role="row">
                                                <td colspan="2" align="center"><input type="submit" name="save" value="حفظ" /></td>
                                            </tr>
                        				</tbody>
                        			</table>
                                    </form>
                                    <script type="text/javascript">
									$("#addVacFRM").submit(function(event) {
									  if ( $( "#vac_dur" ).val() > 0 ) {
										alert("يرجى التأكد من الموافقة على الإجازة بصورة نهائية وتوقيعك عليها كي لا يتم إحتسابها غياب بدون إذن!!");  
										return;
									  }else{
									    alert("من فضلك حدد مدة الإجازة أو تواصل مع شؤون الموظفين!");
										event.preventDefault();
									  }
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
        <?php if(isset($staff_id) && $vacation_type['vacation_type_from_balance'] > 0 && staffBalance($staff_id, $plan['plan_id'], $tdh) < 1){ ?>
		<script type="text/javascript">
			alert("ليس لديك رصيد إجازات لكي تتمكن من طلب إجازة <?=$vacation_type['vacation_type_title']?> من فضلك راجع شؤون الموظفين.!");
			window.location = "index.php?c=hcp-staffvacations";
		</script>
        <?php } ?>