		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> تعريف الإجازات</div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=hcp-vacations" method="post">
                                    <input type="hidden" name="act" value="save" />
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <th>العنوان</th>
                                                <th>المدة القصوى</th>
                                                <th>من الرصيد</th>
                                                <th>مع الراتب</th>
                                                <th>تحتاج سبب</th>
                                                <th>تحتاج مرفق</th>
                                                <th>تحتاج مباشرة</th>
                                                <th>للموظفين</th>
                                                <th></th>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										foreach($vac as $v){
											$cls1 = ( $i%2 ) > 0 ? 'odd' : 'even';
											$cls2 = ( $i%2 ) > 0 ? 'even' : 'odd';
											if(isset($_GET['id']) && $_GET['id'] == $v['vacation_type_id']){
											?>
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><input type="hidden" name="id" value="<?=$v['vacation_type_id']?>" /><?=$i?></td>
                                                <td><input type="text" name="vac[vacation_type_title]" value="<?=$v['vacation_type_title']?>" required size="20" /></td>
                                                <td><input type="text" name="vac[vacation_type_max_duration]" value="<?=$v['vacation_type_max_duration']?>" required size="2" /></td>
                                                <td>
                                                	<select name="vac[vacation_type_from_balance]" size="1">
                                                    	<option value="1"<?php if($v['vacation_type_from_balance'] == 1){ ?> selected<?php } ?>><?=yesNo(1)?></option>
                                                        <option value="0"<?php if($v['vacation_type_from_balance'] == 0){ ?> selected<?php } ?>><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_with_salary]" size="1">
                                                    	<option value="1"<?php if($v['vacation_type_with_salary'] == 1){ ?> selected<?php } ?>><?=yesNo(1)?></option>
                                                        <option value="0"<?php if($v['vacation_type_with_salary'] == 0){ ?> selected<?php } ?>><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_need_resone]" size="1">
                                                    	<option value="1"<?php if($v['vacation_type_need_resone'] == 1){ ?> selected<?php } ?>><?=yesNo(1)?></option>
                                                        <option value="0"<?php if($v['vacation_type_need_resone'] == 0){ ?> selected<?php } ?>><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_need_attachment]" size="1">
                                                    	<option value="1"<?php if($v['vacation_type_need_attachment'] == 1){ ?> selected<?php } ?>><?=yesNo(1)?></option>
                                                        <option value="0"<?php if($v['vacation_type_need_attachment'] == 0){ ?> selected<?php } ?>><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_need_cut]" size="1">
                                                    	<option value="1"<?php if($v['vacation_type_need_cut'] == 1){ ?> selected<?php } ?>><?=yesNo(1)?></option>
                                                        <option value="0"<?php if($v['vacation_type_need_cut'] == 0){ ?> selected<?php } ?>><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_status]" size="1">
                                                    	<option value="1"<?php if($v['vacation_type_status'] == 1){ ?> selected<?php } ?>><?=yesNo(1)?></option>
                                                        <option value="0"<?php if($v['vacation_type_status'] == 0){ ?> selected<?php } ?>><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td><input type="submit" name="save" value="حفظ" /></td>
                                            </tr>    
                                            <?php
											}else{
											?>
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td><a href="index.php?c=hcp-vacations&id=<?=$v['vacation_type_id']?>"><?=$v['vacation_type_title']?></a></td>
                                                <td><?=$v['vacation_type_max_duration'] > 0 ? $v['vacation_type_max_duration']." يوم" : "الرصيد المتاح" ?></td>
                                                <td><?=yesNo($v['vacation_type_from_balance'])?></td>
                                                <td><?=yesNo($v['vacation_type_with_salary'])?></td>
                                                <td><?=yesNo($v['vacation_type_need_resone'])?></td>
                                                <td><?=yesNo($v['vacation_type_need_attachment'])?></td>
                                                <td><?=yesNo($v['vacation_type_need_cut'])?></td>
                                                <td><?=yesNo($v['vacation_type_status'])?></td>
                                                <td><input type="button" name="delete" value="حذف" onclick="confDelete('index.php?c=hcp-vacations&delete=<?=$v['vacation_type_id']?>')" /></td>
                                            </tr>
                                            <?php
											}
											$i++;
										}
										if(!isset($_GET['id'])){
											?>
                                            <td><?=$i?></td>
                                                <td><input type="text" name="vac[vacation_type_title]" value="" required size="20" /></td>
                                                <td><input type="text" name="vac[vacation_type_max_duration]" value="0" required size="2" /></td>
                                                <td>
                                                	<select name="vac[vacation_type_from_balance]" size="1">
                                                    	<option value="1"><?=yesNo(1)?></option>
                                                        <option value="0"><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_with_salary]" size="1">
                                                    	<option value="1"><?=yesNo(1)?></option>
                                                        <option value="0"><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_need_resone]" size="1">
                                                    	<option value="1"><?=yesNo(1)?></option>
                                                        <option value="0"><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_need_attachment]" size="1">
                                                    	<option value="1"><?=yesNo(1)?></option>
                                                        <option value="0"><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_need_cut]" size="1">
                                                    	<option value="1"><?=yesNo(1)?></option>
                                                        <option value="0"><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                	<select name="vac[vacation_type_status]" size="1">
                                                    	<option value="1"><?=yesNo(1)?></option>
                                                        <option value="0"><?=yesNo(0)?></option>
                                                    </select>
                                                </td>
                                                <td><input type="submit" name="save" value="حفظ" /></td>
                                            </tr>
                                            <?php
										}
										?>
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