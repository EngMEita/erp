		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> الخطط</div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <th>العنوان</th>
                                                <th>من</th>
                                                <th>إلى</th>
                                                <th colspan="3">العمليات</th>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										foreach($plans as $p){
											$cls1 = ( $i%2 ) > 0 ? 'odd' : 'even';
											$cls2 = ( $i%2 ) > 0 ? 'even' : 'odd';
											if(isset($_GET['plan_id']) && $_GET['plan_id'] == $p['plan_id'] && canSeePage('hcp', $_SESSION['staff']['rolls'])){
											?>
                                            <form action="index.php?c=hcp-plans" method="post">
                                            <input type="hidden" name="act" value="edit" />
                                            <input type="hidden" name="plan_id" value="<?=$p['plan_id']?>" />
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td><input type="text" name="plan_title" value="<?=$p['plan_title']?>" required size="40" /></td>
                                                <td><input type="text" name="plan_start_date" value="<?=formatDate($p['plan_start_date'], "yyyy-mm-dd")?>" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                                                <td><input type="text" name="plan_end_date" value="<?=formatDate($p['plan_end_date'], "yyyy-mm-dd")?>" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                                                <td><input type="submit" name="save" value="حفظ" /></td>
                                                <td colspan="2"><input type="button" name="cancel" value="إلغاء" onClick="window.location = 'index.php?c=hcp-plans'" /></td>
                                            </tr>    
                                            </form>
                                            <?php
											}else{
											?>
                                            <tr role="row" class="<?=$cls1?>">
                                            	<td><?=$i?></td>
                                                <td>
                                                	<?php if(canSeePage('hcp', $_SESSION['staff']['rolls'])){ ?>
                                                	<a href="index.php?c=hcp-plans&plan_id=<?=$p['plan_id']?>" title="تحديث"><?=$p['plan_title']?></a>
                                                    <?php }else{ ?>
                                                    <?=$p['plan_title']?>
                                                    <?php } ?>
                                               	</td>
                                                <td><?=formatDate($p['plan_start_date'], "yyyy-mm-dd")?></td>
                                                <td><?=formatDate($p['plan_end_date'], "yyyy-mm-dd")?></td>
                                                <td><input type="button" name="planMonths" value="شهور الخطة" onclick="urlOpenner('index.php?c=hcp-planmonths&r=<?=$r?>&plan_id=<?=$p['plan_id']?>');" /></td>
                                                <td><input type="button" name="staffPlans" value="خطط الموظفين" onclick="urlOpenner('index.php?c=hcp-staffplans&plan_id=<?=$p['plan_id']?>');" /></td>
                                                <td>
                                                	<?php if(canSeePage('hcp', $_SESSION['staff']['rolls'])){ ?>
                                                	<input type="button" name="delete" value="حذف" onclick="confDelete('index.php?c=hcp-plans&delete=<?=$p['plan_id']?>')" />
                                                    <?php } ?>
                                               	</td>
                                            </tr>
                                            <?php
											}
											$i++;
										}
										if(!isset($_GET['plan_id']) && $r == "hcp"){
											?>
                                            <form action="index.php?c=hcp-plans" method="post">
                                            <input type="hidden" name="act" value="add" />
                                            <tr role="row" class="<?=$cls2?>">
                                            	<td><?=$i?></td>
                                                <td><input type="text" name="plan_title" value="" required size="40" /></td>
                                                <td><input type="text" name="plan_start_date" value="" placeholder="<?=hYear()?>-01-01" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                                                <td><input type="text" name="plan_end_date" value="" placeholder="<?=hYear()?>-12-30" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" size="8" /></td>
                                                <td colspan="3"><input type="submit" name="save" value="حفظ" /><input type="reset" name="cancel" value="إلغاء" /></td>
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