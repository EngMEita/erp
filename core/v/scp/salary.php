<?php if(!isset($_SESSION['my_data']) || in_array($_SESSION['my_data']['staff_id'], array(101, 105, 107, 128))){ ?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> بيان راتب شهر <?=$mmm['ar_month_name']?> &raquo; </div>
                    </div>
                    <div class="panel-body pn">                    
                    	<table class="table no-footer">
                            <tbody>
                            	<tr role="row">
                                	<td align="left" width="50%"><strong>الأساسي</strong>: </td>
                                    <td align="right" width="50%"><?=number_format($sms['basic'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <tr role="row">
                                	<td align="center" colspan="2"><strong>إستحقاقات</strong></td>
                                </tr>
                                <tr role="row">
                                	<td align="left"><strong>بدل إنتقال</strong>: </td>
                                    <td align="right"><?=number_format($sms['badal_transport'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php if($sms['badal_sakan'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>بدل سكن</strong>: </td>
                                    <td align="right"><?=number_format($sms['badal_sakan'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php } ?>
                                <?php if($sms['badal_worknature'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>بدل ندرة</strong>: </td>
                                    <td align="right"><?=number_format($sms['badal_worknature'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php } ?>
                                <?php if($sms['badal_entedab'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>بدل إنتداب</strong>: </td>
                                    <td align="right"><?=number_format($sms['badal_entedab'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php } ?>
                                <?php if($sms['badal_takleef'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>بدل تكليف</strong>: </td>
                                    <td align="right"><?=number_format($sms['badal_takleef'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php } ?>
                                <?php if($sms['badal_communication'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>بدل تميز</strong>: </td>
                                    <td align="right"><?=number_format($sms['badal_communication'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php } ?>
                                <?php if($sms['extras'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>إضافي</strong>: </td>
                                    <td align="right"><?=number_format($sms['extras'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php } ?>
                                <?php if($sms['awards'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>أخرى</strong>: </td>
                                    <td align="right"><?=number_format($sms['awards'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php } ?>
                                <tr role="row">
                                	<td align="center" colspan="2"><strong>إستقطاعات</strong></td>
                                </tr>
                                <tr role="row">
                                	<td align="left"><strong>تأخير / غياب</strong>: </td>
                                    <td align="right"><?=number_format($sms['delays'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php if($sms['loans'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>سلف</strong>: </td>
                                    <td align="right"><?=number_format($sms['loans'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php } ?>
                                <?php if($sms['discounts'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>أخرى</strong>: </td>
                                    <td align="right"><?=number_format($sms['discounts'], 2, '.', ',')?> ريال</td>
                                </tr>
                                <?php } ?>
                                <?php if($sms['isp'] > 0){ ?>
                                <tr role="row">
                                	<td align="left"><strong>تأمينات حصة الفرد</strong>: </td>
                                    <td align="right"<?=number_format($sms['isp'], 2, '.', ',')?> ريال></td>
                                </tr>
                                <?php } ?>
                                <tr role="row">
                                	<td align="center" colspan="2"><strong>الصافي المستحق</strong></td>
                                </tr>
                                <tr role="row">
                                	<td align="center" colspan="2"><strong><?=number_format($tot, 2, '.', ',')?> ريال</strong></td>
                                </tr>
                                <tr role="row">
                                	<td colspan="2" align="center"><strong>فقط <?=str_replace(" و صفر هللة", "", $Arabic->money2str($tot, 'SAR', 'ar'))?> لاغير.</strong></td>
                                </tr>
                            </tbody>
                       	</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else{ ?>
<p align="center">بيانات سرية لا يحق الإطلاع عليها</p>
<?php } ?>