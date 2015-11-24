
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> <a href="index.php?c=ccp-circulars">التعاميم الإدارية</a> &raquo; جديد &raquo; </div>
                    </div>
                    <div class="panel-body pn">
                    	<form action="<?=$baseUrl?>index.php?c=ccp-circulars&act=save" method="post" enctype="multipart/form-data">
                        	<input type="hidden" name="staff_id" value="<?=$_SESSION['staff']['staff_id']?>" />
                            <input type="hidden" name="circular_time" value="<?=time()?>" />
                            <table class="table no-footer">
                                <tbody>
                                    <tr role="row">
                                        <td align="right" width="33%" valign="top"><strong>الموضوع</strong>: </td>
                                        <td align="right" valign="top"><input type="text" name="circular_title" value="" size="50" required /></td>
                                    </tr>
                                    <tr role="row">
                                        <td align="right" width="33%" valign="top"><strong>المحتوى</strong>: </td>
                                        <td align="right" valign="top"><textarea name="circular_text" cols="48" rows="5" required></textarea></td>
                                    </tr>
                                    <tr role="row">
                                        <td align="right" width="33%" valign="top"><strong>التاريخ</strong>: </td>
                                        <td align="right" valign="top"><input type="text" name="circular_date" value="" placeholder="1437-01-01" size="10" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" /></td>
                                    </tr>
                                    <tr role="row">
                                        <td align="right" width="33%" valign="top"><strong>الأهمية</strong>: </td>
                                        <td align="right" valign="top">
                                        	<select name="circular_periorty" size="1">
                                            	<?php for($p = 0; $p <= 3; $p++){ ?>
                                            	<option value="<?=$p?>"><?=circularPeriorty($p)?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr role="row">
                                        <td align="right" width="33%" valign="top"><strong>الحالة</strong>: </td>
                                        <td align="right" valign="top">
                                        	<select name="circular_status" size="1">
                                            	<?php for($p = 0; $p <= 3; $p++){ ?>
                                            	<option value="<?=$p?>"><?=circularStatus($p)?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr role="row">
                                        <td align="right" width="33%" valign="top"><strong>الصورة</strong>: </td>
                                        <td align="right" valign="top"><input type="file" name="circular_image" /></td>
                                    </tr>
                                    <tr role="row">
                                        <td align="left" colspan="2"><input type="submit" name="save" value="حفظ" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                  	</div>
             	</div>
         	</div>
      	</div>
  	</div>
</div>                