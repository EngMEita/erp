<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> المراسلات &raquo; <?=$pgTitle?> &raquo; </div>
                    </div>
                    <div class="panel-body pn">
                    	<form action="index.php?c=messages&mod=send" method="post" enctype="multipart/form-data">
      					<table class="table no-footer">
                            <tbody>
                                <tr role="row">
                                	<td align="left" valign="top"><strong>إلى</strong>: </td>
                                    <td align="right" valign="top">
                                    	<input type="hidden" name="from" value="<?=$_SESSION['staff']['staff_id']?>" />
                                        <input type="hidden" name="m[message_type]" value="<?=$st?>" />
                                    	<input type="text"   name="tos" id="toStaffSel" required="required" />
                                        <script type="text/javascript">
										$(document).ready(function() {
											$("#toStaffSel").tokenInput([<?=getTos($_SESSION['staff']['staff_id'], false)?>], {
												theme: "facebook",
												hintText: "أكتب اسم من ترغب في مراسلته...",
												noResultsText: "غير موجود!",
												searchingText: "جاري البحث..."<?php if($st == 1){ ?>,
												prePopulate: [<?=getTos($om['staff_id'], true)?>]<?php } ?>
											});
										});
										</script>
                                    </td>
                                </tr>
                                <tr role="row">
                                	<td align="left" valign="top"><strong>العنوان</strong>: </td>
                                    <td align="right" valign="top"><input type="text" name="m[message_title]" value="<?=$msgTtl?><?php if(!is_null($om)){ echo $om['message_title']; } ?>" size="50" required="required" /></td>
                                </tr>
                                <tr role="row">
                                	<td align="left" valign="top"><strong>الرسالة</strong>: </td>
                                    <td align="right" valign="top">
                                    <textarea name="m[message_text]" cols="48" rows="10"><?php if(!is_null($om)){ echo "\n&nbsp;\r\n----------------\r\n".$om['message_text']; } ?></textarea>
                                    </td>
                                </tr>
                                <tr role="row">
                                	<td align="left" valign="top"><strong>المرفقات</strong>: </td>
                                    <td align="right" valign="top">
                                    	<?php for($g = 0; $g < 5; $g++){ ?>
                                    	<input type="hidden" name="a[<?=$g?>]" value="attach_<?=$g?>" />
                                    	<input type="file" name="attach_<?=$g?>" size="50" />
                                        <?php } ?>
                                    </td>
                                </tr>
                           	</tbody>
                            <tfoot>
                            	<tr role="row">
                                	<td colspan="2" align="center">
                                    	<input type="submit" name="send" value="إرسال" />
                                    </td>
                                </tr>
                            </tfoot>
                   		</table>
                        </form>                                              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>