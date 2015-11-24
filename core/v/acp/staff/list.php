<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> الموظفين &raquo; </div>
                    </div>
                    <div class="panel-body pn">                        
                        <table class="table no-footer" id="DTable" data-order='[[ 7, "asc" ]]' data-page-length='50'>
                            <thead>
                                <tr role="row">
                                	<?php if(canSeePage('acp', $_SESSION['staff']['rolls'])){ ?>
                                    <th data-orderable="false">اسم الدخول</th>
                                    <?php } ?>
                                    <th>الاسم</th>
                                    <th>الجنسية</th>
                                    <th>الكفالة</th>
                                    <th data-orderable="false">الجوال</th>
                                    <th>العمر</th>
                                    <th data-orderable="false">الهوية</th>
                                    <th>الإنتهاء</th>
                                    <th data-orderable="false">
                                    	<input type="button" name="add" value="جديد +" onclick="window.location = 'index.php?c=acp-addstaff';" />
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$rns = 0;
							$rds = array();
                            foreach($staff as $s){
                                ?>
                                <tr role="row">
                                	<?php if(canSeePage('acp', $_SESSION['staff']['rolls'])){ ?>
                                    <td><a href="index.php?c=acp-rolls&staff_id=<?=$s['staff_id']?>&KeepThis=true&TB_iframe=true&height=200&width=400&modal=true" title="صلاحيات الدخول لـ '<?=$s['staff_shortname']?>'" class="thickbox"><?=$s['staff_username']?></a></td>
                                    <?php } ?>
                                    <td data-search="<?=$s['staff_fullname']?>"><a href="index.php?c=profile&staff_id=<?=$s['staff_id']?>"><?=$s['staff_shortname']?></a></td>
                                    <td><?=$s['country_nationality']?></td>
                                    <td data-search="<?=$s['kafeel_name']?>"><?=$s['kafala'] == "" ? $s['kafeel_name'] : $s['kafala']?></td>
                                    <td><?=$s['staff_mobile']?></td>
                                    <td><?=$s['staff_age']?></td>
                                    <td><?=$s['staff_ssid']?></td>
                                    <td data-order="<?=$s['staff_ssid_exdate']?>"<?php if($s['ssid_days'] <= 90){ $rns++; $rds[] = $s['ssid_days']; ?> style="color:#F00;"<?php } ?>><?=$s['ssid_exdate']?></td>
                                    <td>
                                    	<select name="options" id="optionSel_<?=$s['staff_id']?>" size="1" onchange="openURL('optionSel_<?=$s['staff_id']?>', '');">
                                        	<option value="index.php?c=acp-staff" selected="selected"> -- إختر -- </option>
                                            <option value="index.php?c=acp-editstaff&staff_id=<?=$s['staff_id']?>&t=l">تحديث بيانات الدخول</option>
                                            <option value="index.php?c=acp-editstaff&staff_id=<?=$s['staff_id']?>&t=p">تحديث البيانات الشخصية</option>
                                            <?php if(($s['staff_id'] != $_SESSION['staff']['staff_id'] && in_array($_SESSION['staff']['staff_id'], array(101, 105, 107, 128))) || ( $s['staff_id'] != $_SESSION['staff']['staff_id'] && !isset($_SESSION['my_data']) && !in_array($s['staff_id'], array(101, 105, 107, 128)))){ ?>
                                            <option value="index.php?a=login_as&staff_id=<?=$s['staff_id']?>"> -- دخـــول --</option>
                                            <?php } ?>
                                        </select>
                                        <?php if(canSeePage('acp', $_SESSION['staff']['rolls']) && !in_array($s['staff_id'], array(101, 102, 105, 107, 128))){ ?>
                                        <input type="button" name="delete" value="حذف -" onclick="confDelete('index.php?c=acp-staff&delete=<?=$s['staff_id']?>');" />
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <?php if($rns > 0){ ?>
                            <tfoot>
                            	<tr>
                                	<td colspan="9" align="center" style="color:#F00;">يوجد عدد <?=$rns?> هوية تحتاج تجديد خلال من <?=min($rds)?> إلى <?=max($rds)?> يوم</td>
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