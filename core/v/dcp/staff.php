<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> الموظفين &raquo; </div>
                    </div>
                    <div class="panel-body pn">                        
                        <table class="table no-footer" id="DTable" data-order='[[ 0, "asc" ]]' data-page-length='50'>
                            <thead>
                                <tr role="row">
                                    <th>م.</th>
                                    <th>الاسم</th>
                                    <th>الجوال</th>
                                    <th>المسمى الوظيفي</th>
                                    <th>الدرجة الوظيفية</th>
                                    <th>تاريخ الإلتحاق</th>
                                    <th>العمر</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$i = 1;
                            foreach($staff as $s){
                                ?>
                                <tr role="row">
                                    <td><?=$i?></td>
                                    <td data-search="<?=$s['staff_fullname']?>"><a href="index.php?c=profile&staff_id=<?=$s['staff_id']?>"><?=$s['staff_shortname']?></a></td>
                                    <td><?=$s['staff_mobile']?></td>
                                    <td><?=$s['job_title']?></td>
                                    <td data-order="<?=$s['work_pos_id']?>"><?=$s['work_pos_title']?></td>
                                    <td data-order="<?=$s['dept_joindate']?>"><?=formatDate($s['dept_joindate'], "yyyy/mm/dd T")?></td>
                                    <td><?=$s['staff_age']?></td>
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