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
                                    <th>تاريخ التعاقد</th>
                                    <th>المدة التجريبية</th>
                                    <th>مدة العقد</th>
                                    <th>يجدد تلقائيا</th>
                                    <th>نوع التعاقد</th>
                                    <th data-orderable="false">صورة العقد</th>
                                    <th data-orderable="false">ملاحظات</th>
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
                                    <td><a href="index.php?c=hcp-contract&contract_id=<?=$cntr['contract']['contract_id']?>"><?=Fld("staff", "staff_id", $cntr['contract']['staff_id'], "staff_fullname")?></a></td>
                                    <td data-order="<?=$cntr['contract']['contract_date']?>"><?=formatDate($cntr['contract']['contract_date'], "yyyy-mm-dd")?></td>
                                    <td data-order="<?=$cntr['contract']['contract_test_duration']?>"><?=$cntr['contract']['contract_test_duration']?> شهر</td>
                                    <td data-order="<?=$cntr['contract']['contract_duration']?>"><?=$cntr['contract']['contract_duration']?> شهر</td>
                                    <td data-order="<?=$cntr['contract']['contract_renewable']?>"><?=yesNo($cntr['contract']['contract_renewable'])?></td>
                                    <td data-order="<?=$cntr['contract']['contract_type']?>"><?=contractType($cntr['contract']['contract_type'])?></td>
                                    <td><?php if($cntr['contract']['contract_image'] != ""){ ?>[ <a href="contracts/<?=$cntr['contract']['contract_image']?>" target="_blank">صورة العقد</a> ]<?php } ?></td>
                                    <td><?php if(is_array($cntr['ending']) && $cntr['ending']['ending_date'] != ""){ ?><a href="index.php?c=hcp-contractending&contract_id=<?=$cntr['contract']['contract_id']?>">تم إنهاء التعاقد في <?=formatDate($cntr['ending']['ending_date'], "yyyy-mm-dd")?></a><?php } ?></td>
                                    <td>
                                    	<select name="ops" size="1" id="Ops_<?=$i?>" class="change">
                                        	<option value="index.php?c=hcp-contracts">-- اختر --</option>
                                            <optgroup label="عمليات أساسية">
                                            	<option value="index.php?c=hcp-contract&act=edit&contract_id=<?=$cntr['contract']['contract_id']?>">تحديث العقد</option>
                                            	<option value="index.php?c=hcp-contract&act=delete&contract_id=<?=$cntr['contract']['contract_id']?>">حذف العقد</option>
                                            </optgroup>
                                            <optgroup label="عمليات إدارية">
                                            	<option value="index.php?c=hcp-contract&act=renew&contract_id=<?=$cntr['contract']['contract_id']?>">تجديد العقد</option>
                                            	<option value="index.php?c=hcp-contract&act=ending&contract_id=<?=$cntr['contract']['contract_id']?>">إنهاء العقد</option>
                                            </optgroup>
                                        </select>
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