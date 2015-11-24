		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> الإدارات والأقسام &raquo; <?=$parentStr?><?=$deptName?></div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <th>العنوان</th>
                                                <th>المدير</th>
                                                <th>الموظفين</th>
                                                <th>&nbsp;</th>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										if(is_array($childs)){
											foreach($childs as $child){
												$cls1 = ( $i%2 ) > 0 ? 'odd' : 'even';
												if(isset($_GET['edit_id']) && $_GET['edit_id'] == $child['dept_id']){
												?>
												<form action="index.php?c=acp-depts&dept_id=<?=$deptId?>" method="post">
												<input type="hidden" name="act" value="edit" />
												<input type="hidden" name="dept_id" value="<?=$child['dept_id']?>" />
												<tr role="row" class="<?=$cls1?>">
													<td><?=$i?></td>
													<td colspan="3"><input type="text" name="dept_name" value="<?=$child['dept_name']?>" required size="60" /></td>
													<td><input type="submit" name="save" value="حفظ" /><input type="button" name="cancel" value="إلغاء" onClick="window.location = 'index.php?c=acp-depts&dept_id=<?=$deptId?>'" /></td>
												</tr>    
												</form>
												<?php
												}else{
												?>
												<tr role="row" class="<?=$cls1?>">
													<td><?=$i?></td>
													<td><a href="index.php?c=acp-depts&dept_id=<?=$child['dept_id']?>"><?=$child['dept_name']?></a></td>
                                                    <td><?=$child['head']?></td>
                                                    <td><a href="index.php?c=acp-deptstaff&dept_id=<?=$child['dept_id']?>"><?=$child['staff']?> موظف</a></td>
													<td>
														<input type="button" name="edit" value="تحديث" onClick="window.location = 'index.php?c=acp-depts&dept_id=<?=$deptId?>&edit_id=<?=$child['dept_id']?>'" />
														<input type="button" name="delete" value="حذف" onclick="confDelete('index.php?c=acp-depts&delete=<?=$child['dept_id']?>')" />
													</td>
												</tr>
												<?php
												}
												$i++;
											}
										}
										$cls2 = ( $i%2 ) > 0 ? 'odd' : 'even';
										if(!isset($_GET['edit_id'])){
											?>
                                            <form action="index.php?c=acp-depts&dept_id=<?=$deptId?>" method="post">
                                            <input type="hidden" name="act" value="add" />
                                            <input type="hidden" name="dept_parent" value="<?=$deptId?>" />
                                            <tr role="row" class="<?=$cls2?>">
                                            	<td><?=$i?></td>
                                                <td colspan="3"><input type="text" name="dept_name" value="" required size="60" /></td>
                                                <td><input type="submit" name="save" value="حفظ" /><input type="reset" name="cancel" value="إلغاء" /></td>
                                            </tr>    
                                            </form>
                                            <?php
										}
										?>
                        				</tbody>
                        			</table>
                        
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
        <!-- /#page-wrapper -->