<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> عقود الموظفين &raquo; </div>
                    </div>
                    <div class="panel-body pn">                        
                        <table class="table no-footer" id="DTable" data-order='[[ 2, "asc" ]]' data-page-length='50'>
                            <thead>
                                <tr role="row">
                                    <th>م.</th>
                                    <th>الاسم</th>
                                    <th>التاريخ</th>
                                    <th>المدة</th>
                                    <th>يجدد</th>
                                    <th>النوع</th>
                                    <th data-orderable="false">الصورة</th>
                                    <th data-orderable="false">الملاحظات</th>
                                    <th data-orderable="false"><input type="button" name="add" value="جديد +" onclick="window.location = 'index.php?c=hcp-contract&contract_id=0';" /></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$i = 1;
                            foreach($cntrs as $cntr){
                                ?>
                                <tr role="row">
                                    <td><?=$i?></td>
                                    <td data-search="<?=Fld("staff", "staff_id", $cntr['contract']['staff_id'], "staff_fullname")?>"><a href="index.php?c=hcp-contract&contract_id=<?=$cntr['contract']['contract_id']?>"><?=Fld("staff", "staff_id", $cntr['contract']['staff_id'], "staff_fullname")?></a></td>
                                    <td data-order="<?=$cntr['contract']['contract_date']?>"><?=formatDate($cntr['contract']['contract_date'], "yyyy-mm-dd")?></td>
                                    <td data-order="<?=$cntr['contract']['contract_duration']?>"><?=$cntr['contract']['contract_duration']?> شهر</td>
                                    <td data-order="<?=$cntr['contract']['contract_renewable']?>"><?=yesNo($cntr['contract']['contract_renewable'])?></td>
                                    <td data-order="<?=$cntr['contract']['contract_type']?>"><?=contractType($cntr['contract']['contract_type'])?></td>
                                    <td><?php if($cntr['contract']['contract_image'] != ""){ ?><a href="contracts/<?=$cntr['contract']['contract_image']?>" target="_blank">صورة العقد</a><?php }else{ ?> - <?php } ?></td>
                                    <td><?php if(is_array($cntr['ending']) && $cntr['ending']['ending_date'] != ""){ ?>تم إنهاء التعاقد في <?=formatDate($cntr['ending']['ending_date'], "dd-mm-yyyy")?><?php } ?></td>
                                    <td>
                                    	<input type="button" name="edit" value="تحديث" onclick="window.location = 'index.php?c=hcp-contract&act=edit&contract_id=<?=$cntr['contract']['contract_id']?>';" />
                                        <input type="button" name="delete" value="حذف" onclick="window.location = 'index.php?c=hcp-contract&act=delete&contract_id=<?=$cntr['contract']['contract_id']?>';" />
                                    </td>
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
    </div>
</div>