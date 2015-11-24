		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> الإضافي</div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<?php if(!canSeePage('fcp', $_SESSION['staff']['rolls'])){ ?>
                                	<?php if(isset($_GET['extra_id'])){ ?>
                                    <form action="index.php?c=hcp-timesheet&mid=<?=$mid?><?=$pst?>&act=saveextras&extra_id=<?=$_GET['extra_id']?>" method="post">
                                    <?php }else{ ?>
                                    <form action="index.php?c=hcp-timesheet&mid=<?=$mid?><?=$pst?>&act=saveextras" method="post">
                                    <?php } ?>
                                    <?php } ?>
                                    <a name="extras"></a>
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <th>اليوم</th>
                                                <th>م. ح. </th>
                                                <th>من</th>
                                                <th>إلى</th>
                                                <th>الفعلي</th>
                                                <th>المحسوب</th>
                                                <th>ملاحظات</th>
                                                <th>&nbsp;</th>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										foreach($exs as $ex){
											$cls1 = ( $i%2 ) > 0 ? 'odd' : 'even';
											$cls2 = ( $i%2 ) > 0 ? 'even' : 'odd';
											if(isset($_GET['extra_id']) && $_GET['extra_id'] == $ex['extra_id'] && !canSeePage('fcp', $_SESSION['staff']['rolls'])){
											?>
                                            <input type="hidden" name="extra_id" value="<?=$ex['extra_id']?>" />
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><a name="extras_<?=$ex['extra_id']?>"></a><?=$i?></td>
                                                <td><input type="text" name="extra_day" value="<?=$ex['extra_day']?>" required size="30" /></td>
                                                <td>
                                                	<select name="extra_opr" size="1">
                                                    	<option value="1.0"<?php if($ex['extra_opr'] == 1.0){ ?> selected="selected"<?php } ?>>الساعة ×1.0</option>
                                                        <option value="1.5"<?php if($ex['extra_opr'] == 1.5){ ?> selected="selected"<?php } ?>>الساعة ×1.5</option>
                                                        <option value="2.0"<?php if($ex['extra_opr'] == 2.0){ ?> selected="selected"<?php } ?>>الساعة ×2.0</option>
                                                        <option value="2.5"<?php if($ex['extra_opr'] == 2.5){ ?> selected="selected"<?php } ?>>الساعة ×2.5</option>
                                                        <option value="3.0"<?php if($ex['extra_opr'] == 3.0){ ?> selected="selected"<?php } ?>>الساعة ×3.0</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="extra_from" value="<?=$ex['extra_from']?>" size="5" placeholder="18:00" required="required" /></td>
                                                <td><input type="text" name="extra_to" value="<?=$ex['extra_to']?>" size="5" placeholder="18:00" required="required" /></td>
                                                <td colspan="3"><input type="text" name="comment" value="<?=$ex['comment']?>" size="30" /></td>
                                                <td><input type="submit" name="save" value="حفظ" /><input type="button" name="cancel" value="إلغاء" onClick="window.location = 'index.php?c=hcp-timesheet&mid=<?=$mid?><?=$pst?>'" /></td>
                                            </tr>    
                                            </form>
                                            <?php
											}else{
												$extr = minsToHours(timeDiff($ex['extra_from'], $ex['extra_to'], "a", 0));
												$extc = $extr * $ex['extra_opr'];
												$er += $extr;
												$ec += $extc; 
											?>
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td><a href="index.php?c=hcp-timesheet&mid=<?=$mid?><?=$pst?>&extra_id=<?=$ex['extra_id']?>#extras_<?=$ex['extra_id']?>" title="تحديث"><?=$ex['extra_day']?></a></td>
                                                <td>الساعة ×<?=$ex['extra_opr']?></td>
                                                <td><?=$ex['extra_from']?></td>
                                                <td><?=$ex['extra_to']?></td>
                                                <td><?=$extr?> ساعة</td>
                                                <td><?=$extc?> ساعة</td>
                                                <td><?=$ex['comment']?></td>
                                                <td>
                                                	<?php if(!canSeePage('fcp', $_SESSION['staff']['rolls'])){ ?>
                                                    <input type="button" name="delete" value="حذف" onclick="confDelete('index.php?c=hcp-timesheet&mid=<?=$mid?><?=$pst?>&deleteextra=<?=$ex['extra_id']?>')" />
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
											}
											$i++;
										}
										if(!isset($_GET['extra_id']) && !canSeePage('fcp', $_SESSION['staff']['rolls'])){
											?>
                                            <input type="hidden" name="staff_id" value="<?=$staff_id?>" />
                                            <input type="hidden" name="month_id" value="<?=$mid?>" />
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td><input type="text" name="extra_day" value="" required size="30" /></td>
                                                <td>
                                                	<select name="extra_opr" size="1">
                                                    	<option value="1.0">الساعة ×1.0</option>
                                                        <option value="1.5" selected="selected">الساعة ×1.5</option>
                                                        <option value="2.0">الساعة ×2.0</option>
                                                        <option value="2.5">الساعة ×2.5</option>
                                                        <option value="3.0">الساعة ×3.0</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="extra_from" value="" size="5" placeholder="18:00" required="required" /></td>
                                                <td><input type="text" name="extra_to" value="" size="5" placeholder="18:00" required="required" /></td>
                                                <td colspan="3"><input type="text" name="comment" value="" size="30" /></td>
                                                <td><input type="submit" name="save" value="حفظ" /><input type="reset" name="cancel" value="إلغاء" /></td>
                                            </tr>    
                                            <?php
										}
										?>
                        				</tbody>
                        			</table>
                                    <?php if(!canSeePage('fcp', $_SESSION['staff']['rolls'])){ ?>
                                    </form>
                                   	<?php } ?>
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