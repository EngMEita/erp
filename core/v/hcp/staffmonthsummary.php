<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> الملخص الشهري &raquo; </div>
                    </div>
                    <div class="panel-body pn">
                    	<?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                    	<form name="savesummary" action="index.php?c=hcp-timesheet&mid=<?=$mid?><?=$pst?>&act=savesummary&sms_id=<?=$sms['id']?>" method="post">
                        <?php } ?>
                        <a name="sms"></a>
                        <table class="table no-footer">
                            <thead>
                                <tr role="row">
                                    <th></th>
                                    <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                                    <th colspan="2">المحسوبة</th>
                                    <th>المسجلة</th>
                                    <?php } ?>
                                    <th>الفعلية</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<tr role="row">
                                	<td><strong>تأخيرات</strong>:</td>
                                    <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                                    <td><?=$dr?> دقيقة</td>
                                    <td><?=$dc?> دقيقة</td>
                                    <td><input type="text" name="dr" size="5" value="<?=$sms['delays_real']?>" placeholder="<?=$dr?>" required /> دقيقة</td>
                                    <td><input type="text" name="dc" size="5" value="<?=$sms['delays_count']?>" placeholder="<?=$dc?>" required /> دقيقة</td>
                                    <?php }else{ ?>
                                    <td><?=$sms['delays_count']?> دقيقة</td>
                                    <?php } ?>
                                </tr>
                                <tr role="row">
                                	<td><strong>غياب</strong>:</td>
                                    <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                                    <td><?=$ar?> يوم</td>
                                    <td><?=$ac?> يوم</td>
                                    <td><input type="text" name="ar" size="5" value="<?=$sms['absence_real']?>" placeholder="<?=$ar?>" required /> يوم</td>
                                    <td><input type="text" name="ac" size="5" value="<?=$sms['absence_count']?>" placeholder="<?=$ac?>" required /> يوم</td>
                                    <?php }else{ ?>
                                    <td><?=$sms['absence_real']?> &raquo; <?=$sms['absence_count']?> يوم</td>
                                    <?php } ?>
                                </tr>
                                <tr role="row">
                                	<td><strong>نصف يوم</strong>:</td>
                                    <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                                    <td colspan="2"><?=$hd?> نصف يوم</td>
                                    <td colspan="2"><input type="text" name="hd" size="5" value="<?=$sms['half_days']?>" placeholder="<?=$hd?>" required /> نصف يوم</td>
                                    <?php }else{ ?>
                                    <td><?=$sms['half_days']?> نصف يوم</td>
                                    <?php } ?>
                                </tr>
                                <tr role="row">
                                	<td><strong>إضافي</strong>:</td>
                                    <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                                    <td><?=$er?> ساعة</td>
                                    <td><?=$ec?> ساعة</td>
                                    <td><input type="text" name="er" size="5" value="<?=$sms['extras_real']?>" placeholder="<?=$er?>" required /> ساعة</td>
                                    <td><input type="text" name="ec" size="5" value="<?=$sms['extras_count']?>" placeholder="<?=$ec?>" required /> ساعة</td>
                                    <?php }else{ ?>
                                    <td><?=$sms['extras_count']?> ساعة</td>
                                    <?php } ?>
                                </tr>
                                <tr role="row">
                                	<td><strong>ملاحظات</strong>: </td>
                                    <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                                    <td colspan="4"><input type="text" name="comment" size="100%" value="<?=$sms['comment']?>" /></td>
                                    <?php }else{ ?>
                                    <td><?=$sms['comment']?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                            <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                            <tfoot>
                            	<tr>
                                	<td colspan="5" align="center"> <?php if($sms['last_updates'] > 0){ ?>( اخر تحديث في <?=date("Y/m/d H:i", $sms['last_updates'])?> )<?php } ?> <input type="submit" name="save" value="حفظ" /></td>
                                </tr>
                            </tfoot>
                            <?php } ?>
                        </table>
                        <?php if(!canSeePage( 'fcp', $_SESSION['staff']['rolls'] )){ ?>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>