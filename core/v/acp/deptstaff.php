		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span>  الإدارات والأقسام &raquo; <?=$parentStr?><a href="index.php?c=acp-depts&dept_id=<?=$deptId?>"><?=$deptName?></a> &raquo; الموظفين</div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=acp-deptstaff&dept_id=<?=$deptId?>" method="post">
									<?php if(isset($_GET['id'])){ ?>
                                    <input type="hidden" name="act" value="edit" />
                                    <?php }else{ ?>
                                    <?php if($nds > 0){ ?>
                                    <input type="hidden" name="act" value="add" />
                                    <?php } ?>
									<?php if($dept){ ?>
                                    <input type="hidden" name="dept_id" value="<?=$deptId?>" />
                                    <?php } ?>
                                    <?php } ?>
                            		<table class="table table-striped table-hover dataTable no-footer" id="DTable" data-order='[[ 3, "asc" ]]' data-page-length='50'>
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <th>الاسم</th>
                                                <?php if(!$dept){ ?>
												<th>القسم</th>			
                                                <?php } ?>
                                                <th>الكود</th>
                                                <th>الوظيفة</th>
                                                <th>الدرجة</th>
                                                <th>الإلتحاق</th>
                                                <th data-orderable="false">&nbsp;</th>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										foreach($dss as $ds){
											$staff = getStaff($ds['staff_id']);
											if(isset($_GET['id']) && $_GET['id'] == $ds['id']){
											?>
                                            <tr role="row">
                                            	<td><input type="hidden" name="id" value="<?=$ds['id']?>" /><?=$i?></td>
                                                <td data-search="<?=$staff[0]['staff_fullname']?>" data-order="<?=$staff[0]['staff_fullname']?>"><?=$staff[0]['staff_fullname']?></td>
                                                <?php if(!$dept){ ?>
												<td>
                                                <select name="dept_id" size="1">
                                                <?=deptsListDD($deptsArray, 0, 0, $ds['dept_id'], -1)?>
                                                </select>
                                                </td>			
                                                <?php } ?>
                                                <td><input type="text" name="job_code" value="<?=$ds['job_code']?>" required size="3" /></td>
                                                <td><input type="text" name="job_title" value="<?=$ds['job_title']?>" required size="15" /></td>
                                                <td>
                                                	<select name="work_pos_id" size="1">
                                                    <?php foreach($wps as $wp){ ?>
                                                    	<option value="<?=$wp['work_pos_id']?>"<?php if($wp['work_pos_id'] == $ds['work_pos_id']){ ?> selected="selected"<?php } ?>><?=$wp['work_pos_title']?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="dept_joindate" value="<?=formatDate($ds['dept_joindate'], "yyyy-mm-dd")?>" placeholder="<?=formatDate($tdh, "yyyy-mm-dd")?>" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                                                <td><input type="submit" name="save" value="حفظ" /><input type="reset" name="cancel" value="إلغاء" /></td>
                                            </tr>    
                                            <?php
											}else{
											?>
                                            <tr role="row">
                                            	<td><?=$i?></td>
                                                <td data-search="<?=$staff[0]['staff_fullname']?>" data-order="<?=$staff[0]['staff_fullname']?>"><a href="index.php?c=acp-deptstaff&dept_id=<?=$deptId?>&id=<?=$ds['id']?>" title="تحديث"><?=$staff[0]['staff_fullname']?></a></td>
                                                <?php if(!$dept){ ?>
												<td data-search="<?=Fld("depts", "dept_id", $ds['dept_id'], "dept_name")?>" data-order="<?=Fld("depts", "dept_id", $ds['dept_id'], "dept_name")?>">
                                                    <select name="changeDept_<?=$ds['id']?>" id="changeDept_<?=$ds['id']?>" size="1" onchange="changeDept(<?=$ds['id']?>, <?=$staff[0]['staff_id']?>, 'changeDept_<?=$ds['id']?>');">
                                                    <?=deptsListDD($deptsArray, 0, 0, $ds['dept_id'], -1)?>
                                                    </select>
                                                </td>			
                                                <?php } ?>
                                                <td><?=$staff[0]['job_code']?></td>
                                                <td><?=$staff[0]['job_title']?></td>
                                                <td><?=$staff[0]['work_pos_title']?></td>
                                                <td data-order="<?=$staff[0]['dept_joindate']?>"><?=formatDate($staff[0]['dept_joindate'], "yyyy-mm-dd")?></td>
                                                <td><input type="button" name="delete" value="حذف" onclick="confDelete('index.php?c=acp-deptstaff&dept_id=<?=$deptId?>&delete=<?=$ds['id']?>')" /></td>
                                            </tr>
                                            <?php
											}
											$i++;
										}
										?>
                                        </tbody>
                                        <?php
										if(!isset($_GET['id']) && $nds > 0){
											?>
                                            <tfoot>
                                            <tr role="row">
                                            	<td><?=$i?></td>
                                                <td>
                                                	<select name="staff_id" size="1">
                                                    <?php foreach($nds as $nd){ ?>
                                                    	<option value="<?=$nd['staff_id']?>"><?=$nd['staff_fullname']?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                                <?php if(!$dept){ ?>
												<td>
                                                <select name="dept_id" size="1">
                                                <?=deptsListDD($deptsArray)?>
                                                </select>
                                                </td>			
                                                <?php } ?>
                                                <td><input type="text" name="job_code" value="" required size="3" /></td>
                                                <td><input type="text" name="job_title" value="" required size="15" /></td>
                                                <td>
                                                	<select name="work_pos_id" size="1">
                                                    <?php foreach($wps as $wp){ ?>
                                                    	<option value="<?=$wp['work_pos_id']?>"><?=$wp['work_pos_title']?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="dept_joindate" value="<?=formatDate($tdh, "yyyy-mm-dd")?>" placeholder="<?=formatDate($tdh, "yyyy-mm-dd")?>" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                                                <td><input type="submit" name="save" value="حفظ" /><input type="reset" name="cancel" value="إلغاء" /></td>
                                            </tr>    
                                            </tfoot>
                                            <?php
										}
										?>
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