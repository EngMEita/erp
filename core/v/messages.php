		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> المراسلات &raquo; <?=$pgTitle?> &raquo; </div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            		<table class="table no-footer" id="DTable" data-order='[[ 4, "asc" ], [ 3, "desc" ]]' data-page-length='10'>
                        				<thead>
                        					<tr role="row">
                                            	<th>م.</th>
                                                <?php if($mod == "sent"){ ?>
                                                <th>إلى</th>
                                                <?php }else{ ?>
                                                <th>من</th>
                                                <?php } ?>
                                                <th>العنوان</th>
                                                <th>التاريخ</th>
                                                <th>ملاحظات</th>
                                         	</tr>
                        				</thead>
                        				<tbody>
                                        <?php
										$i = 1;
										foreach($msgs as $m){
											?>
                                            <tr role="row">
                                            	<td><?=$i?></td>
                                                <?php if($mod == "sent"){ ?>
                                                <td><?=Fld("staff", "staff_id", $m['data']['staff_id'], "staff_fullname")?></td>
                                                <?php }else{ ?>
                                                <td><?=Fld("staff", "staff_id", $m['content']['staff_id'], "staff_fullname")?></td>
                                                <?php } ?>
                                                <td><a href="index.php?c=messages&mod=read&id=<?=$m['data']['id']?>"><?php if(!is_null($m['content']['message_attachments'])){ ?>&theta; <?php } ?><?=$m['content']['message_title']?></a></td>
                                                <td data-order="<?=$m['content']['message_date']?>"><?=formatDate(innerDate($m['content']['message_date']))?></td>
                                                <td data-order="<?=$m['data']['message_status']?>"><span title="<?=messageReadingTime($m['data']['id'])?>"><?=messageStatus($m['data']['id'])?></span></td>
                                            </tr>
                                            <?php
											$i++;
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