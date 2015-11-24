		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> السلم الوظيفي</div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <th>المنصب</th>
                                                <th>الرتبة</th>
                                                <th>&nbsp;</th>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										foreach($ws as $w){
											$cls1 = ( $i%2 ) > 0 ? 'odd' : 'even';
											$cls2 = ( $i%2 ) > 0 ? 'even' : 'odd';
											if(isset($_GET['work_pos_id']) && $_GET['work_pos_id'] == $w['work_pos_id']){
											?>
                                            <form action="index.php?c=acp-workpos" method="post">
                                            <input type="hidden" name="act" value="edit" />
                                            <input type="hidden" name="work_pos_id" value="<?=$w['work_pos_id']?>" />
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td><input type="text" name="work_pos_title" value="<?=$w['work_pos_title']?>" required size="60" /></td>
                                                <td><input type="text" name="work_pos_rank" value="<?=$w['work_pos_rank']?>" required size="20" /></td>
                                                <td><input type="submit" name="save" value="حفظ" /><input type="button" name="cancel" value="إلغاء" onClick="window.location = 'index.php?c=acp-workpos'" /></td>
                                            </tr>    
                                            </form>
                                            <?php
											}else{
											?>
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td><?=$w['work_pos_title']?></td>
                                                <td><?=$w['work_pos_rank']?></td>
                                                <td>
                                                	<input type="button" name="edit" value="تحديث" onClick="window.location = 'index.php?c=acp-workpos&work_pos_id=<?=$w['work_pos_id']?>'" />
                                                    <input type="button" name="delete" value="حذف" onclick="confDelete('index.php?c=acp-workpos&delete=<?=$w['work_pos_id']?>')" />
                                                </td>
                                            </tr>
                                            <?php
											}
											$i++;
										}
										if(!isset($_GET['work_pos_id'])){
											?>
                                            <form action="index.php?c=acp-workpos" method="post">
                                            <input type="hidden" name="act" value="add" />
                                            <tr role="row" class="<?=$cls2?>">
                                            	<td><?=$i?></td>
                                                <td><input type="text" name="work_pos_title" value="" required size="60" /></td>
                                                <td><input type="text" name="work_pos_rank" value="" required size="20" /></td>
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