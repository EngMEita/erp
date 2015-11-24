<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> المراسلات &raquo; <?=$msg['content']['message_title']?> [ #<?=$rid?> ] &raquo; </div>
                    </div>
                    <div class="panel-body pn">
      					<table class="table no-footer">
                            <tbody>
                            	<tr role="row">
                                	<td align="left" valign="top"><strong>من</strong>: </td>
                                    <td align="right" valign="top"><?=Fld("staff", "staff_id", $msg['content']['staff_id'], "staff_fullname")?></td>
                                </tr>
                                <tr role="row">
                                	<td align="left" valign="top"><strong>إلى</strong>: </td>
                                    <td align="right" valign="top"><?=Fld("staff", "staff_id", $msg['data']['staff_id'], "staff_fullname")?></td>
                                </tr>
                                <tr role="row">
                                	<td align="left" valign="top"><strong>التاريخ</strong>: </td>
                                    <td align="right" valign="top"><?=formatDate(innerDate($msg['content']['message_date']), "yyyy/mm/dd T")?></td>
                                </tr>
                                <tr role="row">
                                	<td align="left" valign="top"><strong>الرسالة</strong>: </td>
                                    <td align="right" valign="top"><?=nl2br($msg['content']['message_text'])?></td>
                                </tr>
                                <?php if(!is_null($msg['content']['message_attachments'])){ ?>
                                <tr role="row">
                                	<td align="left" valign="top"><strong>المرفقات</strong>: </td>
                                    <td align="right" valign="top"><?=$msg['content']['message_attachments']?></td>
                                </tr>
                                <?php } ?>
                                <tr role="row">
                                	<td align="left" valign="top"><strong>ملاحظات</strong>: </td>
                                    <td align="right" valign="top"><?=messageStatus($rid)?> <?=messageReadingTime($rid)?></td>
                                </tr>
                           	</tbody>
                            <?php if($msg['data']['staff_id'] == $_SESSION['staff']['staff_id']){ ?>
                            <tfoot>
                            	<tr role="row">
                                	<td colspan="2" align="center">
                                    	<input type="button" name="btn_1" value="الرد على الرسالة" onClick="window.location = 'index.php?c=messages&mod=compose&st=1&mid=<?=$msg['content']['message_id']?>';" />
                                        <input type="button" name="btn_2" value="إعادة توجيه الرسالة" onClick="window.location = 'index.php?c=messages&mod=compose&st=2&mid=<?=$msg['content']['message_id']?>';" />
                                        <?php if($msg['data']['message_status'] != 2){ ?>
                                        <input type="button" name="btn_3" value="أرشفة الرسالة" onClick="window.location = 'index.php?c=messages&mod=old&id=<?=$rid?>';" />
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tfoot>
                        	<?php } ?>    
                   		</table>                                              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>