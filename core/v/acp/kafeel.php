		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> الكفلاء</div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <th>الكفيل</th>
                                                <th>كفالة خارجية</th>
                                                <th>&nbsp;</th>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										foreach($ks as $k){
											$cls1 = ( $i%2 ) > 0 ? 'odd' : 'even';
											$cls2 = ( $i%2 ) > 0 ? 'even' : 'odd';
											if(isset($_GET['kafeel_id']) && $_GET['kafeel_id'] == $k['kafeel_id']){
											?>
                                            <form action="index.php?c=acp-kafeel" method="post">
                                            <input type="hidden" name="act" value="edit" />
                                            <input type="hidden" name="kafeel_id" value="<?=$k['kafeel_id']?>" />
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td><input type="text" name="kafeel_name" value="<?=$k['kafeel_name']?>" required size="60" /></td>
                                                <td>
                                                	<select name="kafeel_out" size="1">
                                                    	<option value="-1"<?php if($k['kafeel_out'] == -1){ ?> selected="selected"<?php } ?>> - </option>
                                                    	<option value="0"<?php if($k['kafeel_out'] == 0){ ?> selected="selected"<?php } ?>>لا</option>
                                                        <option value="1"<?php if($k['kafeel_out'] == 1){ ?> selected="selected"<?php } ?>>نعم</option>
                                                    </select>
                                                </td>
                                                <td><input type="submit" name="save" value="حفظ" /><input type="button" name="cancel" value="إلغاء" onClick="window.location = 'index.php?c=acp-kafeel'" /></td>
                                            </tr>    
                                            </form>
                                            <?php
											}else{
											?>
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td><?=$k['kafeel_name']?></td>
                                                <td><?=$k['kafeel_name'] == $k['kafala'] ? '-' : $k['kafala']?></td>
                                                <td>
                                                	<input type="button" name="edit" value="تحديث" onClick="window.location = 'index.php?c=acp-kafeel&kafeel_id=<?=$k['kafeel_id']?>'" />
                                                    <input type="button" name="delete" value="حذف" onclick="confDelete('index.php?c=acp-kafeel&delete=<?=$k['kafeel_id']?>')" />
                                                </td>
                                            </tr>
                                            <?php
											}
											$i++;
										}
										if(!isset($_GET['kafeel_id'])){
											?>
                                            <form action="index.php?c=acp-kafeel" method="post">
                                            <input type="hidden" name="act" value="add" />
                                            <tr role="row" class="<?=$cls2?>">
                                            	<td><?=$i?></td>
                                                <td><input type="text" name="kafeel_name" value="" required size="60" /></td>
                                                <td>
                                                	<select name="kafeel_out" size="1">
                                                    	<option value="-1"> - </option>
                                                    	<option value="0">لا</option>
                                                        <option value="1" selected="selected">نعم</option>
                                                    </select>
                                                </td>
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