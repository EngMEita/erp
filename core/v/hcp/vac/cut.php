		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> نموذج مباشرة &raquo; </div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=vacut&vac_id=<?=$vac_id?>&op=save" method="post"id="addVacutFRM">
                                    <input type="hidden" name="vac_id" value="<?=$vac_id?>" />
                                    <input type="hidden" name="v[vacation_cut_applydate]" value="<?=$tda?>" />
                                    <input type="hidden" name="v[vacation_cut_applytime]" value="<?=time()?>" />
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<tbody>
                                        	<tr role="row">
                                            	<td align="left"><strong>أخر يوم في الإجازة</strong>: </td>
                                                <td align="right">
                                                	<?=formatDate( reverseDate( datePlusDays( Fld('staff_vacations', 'vacation_id', $vac_id, 'vacation_startdate'), Fld( 'staff_vacations', 'vacation_id', $vac_id, 'vacation_duration' ) - 1 ) ), "yyyy-mm-dd T" )?>
                                                    <input type="hidden" name="lastVacDay" id="lastVacDay" value="<?=formatDate( reverseDate( datePlusDays( Fld('staff_vacations', 'vacation_id', $vac_id, 'vacation_startdate'), Fld( 'staff_vacations', 'vacation_id', $vac_id, 'vacation_duration' ) - 1 ) ), "yyyy-mm-dd" )?>" />
                                                    <span id="day_name_2"></span>
                                                    <script type="text/javascript">
														$(document).ready(function(){
                                                            var dt = $("#lastVacDay").val();
															$("#day_name_2").load("<?=$baseUrl?>index.php?c=dayname&dt=" + dt);
                                                        });
													</script>
                                                </td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>تاريخ المباشرة</strong>: </td>
                                                <td align="right">
                                                	<input type="text" name="v[vacation_cut_date]" value="<?=formatDate(datePlusDays($tdh, 0), "yyyy-mm-dd")?>" placeholder="1980-01-01" size="10" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" id="vacutDate" />
                                                    <span id="day_name"></span>
                                                    <script type="text/javascript">
														$(document).ready(function(){
                                                            var dt = $("#vacutDate").val();
															$("#day_name").load("<?=$baseUrl?>index.php?c=dayname&dt=" + dt);
                                                        });
														$("#vacutDate").keyup(function(){
															var dt = $("#vacutDate").val();
															$("#day_name").load("<?=$baseUrl?>index.php?c=dayname&dt=" + dt);
														}); 
													</script>
                                                </td>
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