<style type="text/css">
img.circular{ display:block; width:90%; height:auto; }
</style>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> <a href="index.php?c=ccp-circulars">التعاميم الإدارية</a> &raquo; [ <?=$cirs[0]['circular_id']?> ] <?=$cirs[0]['circular_title']?> &raquo; </div>
                    </div>
                    <div class="panel-body pn">
                        <table class="table no-footer">
                            <tbody>
                                <tr role="row">
                                	<td colspan="3">
                                		<h3 align="center"><?=$cirs[0]['circular_title']?></h3>
                                    	<p align="right" style="text-indent:20px;"><?=nl2br($cirs[0]['circular_text'])?></p>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="2" width="66%"></td>
                                    <td align="center">
                                    	<h4><a href="index.php?c=profile&staff_id=<?=$cirs[0]['staff_id']?>" target="_blank"><?=$s[0]['staff_fullname']?></a></h4>
                                        <p align="center"><strong><?=$s[0]['job_title']?></strong><br /><?=$s[0]['dept_name']?></p>
                                        <p align="center"><?=formatDate($cirs[0]['circular_date'], "dd MM yyyy T")?></p>
                                    </td>
                                </tr>
                                <?php if($cirs[0]['circular_image'] != ""){ ?>
                                <tr>
                                	<td colspan="3" align="center">
                                    <img src="<?=$baseUrl?>circulars/<?=$cirs[0]['circular_image']?>" alt="<?=$cirs[0]['circular_title']?>" class="circular" />
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                   	</div>
             	</div>
         	</div>
      	</div>
  	</div>
</div>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> المشاهدات &raquo; </div>
                    </div>
                    <div class="panel-body pn">
                        <table class="table no-footer"<?php if($cirs[0]['staff_id'] == $_SESSION['staff']['staff_id']){ ?> id="DTable" data-order='[[2, "asc"]]' data-page-length='10'<?php } ?>>
                        	<thead>
                            	<tr role="row">
                                	<th>م.</th>
                                    <th>الاسم</th>
                                    <th>التاريخ</th>
                                    <?php if($cirs[0]['circular_status'] == 1 || $cirs[0]['circular_status'] == 3){ ?>
                                    <th>موافق</th>
                                    <?php } ?>
                                    <?php if($cirs[0]['circular_status'] == 2 || $cirs[0]['circular_status'] == 3){ ?>
                                    <th data-orderable="false">التعليق</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach($cirs[0]['signs'] as $s){ ?>
                            	<tr role="row">
                                	<td><?=$i?></td>
                                    <td><?=Fld("staff", "staff_id", $s['staff_id'], "staff_fullname")?></td>
                                    <td><?=formatDate($s['signe_date'], "yyyy-mm-dd")?></td>
                                    <?php if($cirs[0]['circular_status'] == 1 || $cirs[0]['circular_status'] == 3){ ?>
                                    <td data-order="<?=$s['agreement']?>" data-search="<?=yesNoNot($s['agreement'])?>">
                                    	<?php if($s['agreement'] < 0 && $s['staff_id'] == $_SESSION['staff']['staff_id']){ ?>
                                        <form action="<?=$baseUrl?>index.php?c=ccp-circulars&id=<?=$cirs[0]['circular_id']?>&act=signe" method="post">
                                        <input type="hidden" name="fld" value="agreement" />
                                        <input type="hidden" name="id" value="<?=$s['id']?>" />
                                    	<select name="vlu" size="1">
                                        	<option value="-1">أختر</option>
                                            <option value="0">لا</option>
                                            <option value="1">نعم</option>
                                        </select>
                                        <input type="submit" name="save" value="حفظ" />
                                        </form>
                                        <?php }else{ ?>
                                        <?=yesNoNot($s['agreement'])?>
                                        <?php } ?>
                                    </td>
                                    <?php } ?>
                                    <?php if($cirs[0]['circular_status'] == 2 || $cirs[0]['circular_status'] == 3){ ?>
                                    <td>
                                    	<?php if(is_null($s['comment']) && $s['staff_id'] == $_SESSION['staff']['staff_id']){ ?>
                                        <form action="<?=$baseUrl?>index.php?c=ccp-circulars&id=<?=$cirs[0]['circular_id']?>&act=signe" method="post">
                                        <input type="hidden" name="fld" value="comment" />
                                        <input type="hidden" name="id" value="<?=$s['id']?>" />
                                        <input type="text" name="vlu" value="" size="40" required="required" />
                                        <input type="submit" name="save" value="حفظ" />
                                        </form>
                                        <?php }else{ ?>
                                        <?=$s['comment']?>
                                        <?php } ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>
                            </tbody>
                        </table>
                  	</div>
             	</div>
         	</div>
      	</div>
  	</div>
</div>                