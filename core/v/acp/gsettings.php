		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> إعدادات البرنامج</div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=acp-settings" method="post">
                                    <input type="hidden" name="act" value="save" />
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <th>البيان</th>
                                                <th>القيمة</th>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										foreach($gs as $name => $value){
											$cls1 = ( $i%2 ) > 0 ? 'odd' : 'even';
											$cls2 = ( $i%2 ) > 0 ? 'even' : 'odd';
											?>
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td><strong><?=$gs_titles[$name]?></strong>: </td>
                                                <td><input type="text" name="<?=$name?>" value="<?=$value?>" required size="60" /></td>
                                            </tr>    
                                            <?php
											$i++;
										}
										?>
                                        	<tr role="row" class="<?=$cls2?>">
                                                <td colspan="3" align="left"><input type="submit" name="save" value="حفظ" /></td>
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