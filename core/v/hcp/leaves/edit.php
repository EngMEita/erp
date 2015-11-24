		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> تحرير استئذان <?=Fld("staff", "staff_id", $l['staff_id'], "staff_fullname")?> #<?=$l['leave_id']?> &raquo; </div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=hcp-leaves&act=save" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?=intval($_GET['id'])?>" />
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<tbody>
                                            <tr role="row">
                                            	<td align="left"><strong>التاريخ</strong>: </td>
                                                <td align="right"><input type="text" name="l[leave_date]" value="<?=formatDate($l['leave_date'], "yyyy-mm-dd")?>" placeholder="<?=formatDate($tdh, "yyyy-mm-dd")?>" size="10" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" /></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>المدة</strong>: </td>
                                                <td align="right"><input type="text" name="l[leave_from_time]" value="<?=$l['leave_from_time']?>" size="5" required> - <input type="text" name="l[leave_to_time]" value="<?=$l['leave_to_time']?>" size="5" required></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>السبب</strong>: </td>
                                                <td align="right"><textarea name="l[leave_resone]" cols="30" rows="3" required="required"><?=$l['leave_resone']?></textarea></td>
                                            </tr>
                                        	<tr role="row">
                                                <td colspan="2" align="center"><input type="submit" name="save" value="حفظ" /></td>
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