<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> أرصدة الموظفين &raquo; </div>
                    </div>
                    <div class="panel-body pn">                        
                        <table class="table no-footer" id="DTable" data-order='[[ 5, "desc" ]]' data-page-length='50'>
                            <thead>
                                <tr role="row">
                                    <th>م.</th>
                                    <th>الاسم</th>
                                    <th>الكلي</th>
                                    <th>المأخوذة</th>
                                    <th>الكلي المتاح</th>
                                    <th>المتاح اليوم</th>
                                    <th>أخر إجازة</th>
                                    <th>بتاريخ</th>
                                    <th>لمدة</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$i = 1;
                            foreach($staff as $s){
                                ?>
                                <tr role="row">
                                    <td><?=$i?></td>
                                    <td><?=$s['staff_fullname']?></td>
                                    <td data-order="<?=$s['allBalance']?>"><?=$s['allBalance']?> يوم</td>
                                    <td data-order="<?=$s['totalToken']?>"><?=$s['totalToken']?> يوم</td>
                                    <td data-order="<?=$s['totalBalance']?>"><?=$s['totalBalance']?> يوم</td>
                                    <td data-order="<?=$s['validBalance']?>"<?php if($s['validBalance'] > 55){ ?> style="color:#F00;"<?php } ?>><?=$s['validBalance']?> يوم</td>
                                    <?php if(is_array($s['lastVac'])){ ?>
                                    <td><?=$s['lastVac']['vacation_type_title']?></td>
                                    <td data-order="<?=innerDate($s['lastVac']['vacation_startdate'])?>"><?=formatDate(innerDate($s['lastVac']['vacation_startdate']), "yyyy/mm/dd")?></td>
                                    <td data-order="<?=$s['lastVac']['vacation_duration']?>"><?=$s['lastVac']['vacation_duration']?> يوم</td>
                                    <?php }else{ ?>
                                    <td> - </td>
                                    <td> - </td>
                                    <td data-order="0"> - </td>
                                    <?php } ?>
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