<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> التعاميم الإدارية &raquo; </div>
                    </div>
                    <div class="panel-body pn">                        
                        <table class="table no-footer" id="DTable" data-order='[[1, "desc"],[ 4, "desc" ]]' data-page-length='50'>
                            <thead>
                                <tr role="row">
                                    <th>رقم</th>                                    
                                    <th>الموضوع</th>
                                    <th>بواسطة</th>
                                    <th>التاريخ</th>
                                    <th>الأهمية</th>
                                    <?php if(canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('acp', $_SESSION['staff']['rolls'])){ ?>
                                    <th>المشاهدات</th>
                                    <th data-orderable="false">
                                    	<input type="button" name="add" value="جديد +" onclick="window.location = 'index.php?c=ccp-circulars&act=add';" />
                                    </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($cirs as $c){
                                ?>
                                <tr role="row">
                                    <td><?=$c['circular_id']?></td>
                                    <td data-order="<?=$c['new']?>"><?php if($c['new'] > 0){ ?>[ جديد ] <?php } ?><a href="index.php?c=ccp-circulars&id=<?=$c['circular_id']?>"><?=$c['circular_title']?></a></td>
                                    <td><a href="index.php?c=profile&staff_id=<?=$c['staff_id']?>" target="_blank"><?=Fld("staff", "staff_id", $c['staff_id'], "staff_fullname")?></a></td>
                                    <td><?=formatDate($c['circular_date'], "yyyy/mm/dd")?></td>
                                    <td data-order="<?=$c['circular_periorty']?>"><?=circularPeriorty($c['circular_periorty'])?></td>
                                    <?php if(canSeePage('ccp', $_SESSION['staff']['rolls']) || canSeePage('acp', $_SESSION['staff']['rolls'])){ ?>
                                    <td><?=$c['views']?></td>
                                    <td>
                                    	<select name="ops" id="ops_<?=$c['circular_id']?>" class="change" size="1">
                                        	<option selected>-- إختر --</option>
                                            <option value="index.php?c=ccp-circulars&act=edit&id=<?=$c['circular_id']?>">تحرير</option>
                                            <option value="index.php?c=ccp-circulars&act=delete&id=<?=$c['circular_id']?>">حذف</option>
                                       	</select>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php
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