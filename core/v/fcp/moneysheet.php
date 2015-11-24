<!doctype html>
<html dir="rtl" lang="ar-sa">
<head>
<meta charset="utf-8">
<title>أنجز :: حسابات شهر <?=$mnt['ar_month_name']?> من <?=$pln['plan_title']?></title>
<style type="text/css">
	*{ font-size:6pt; }
   table { page-break-inside:auto }
   tr    { page-break-inside:avoid; page-break-after:auto }

</style>
</head>
<body>
    <table cellpadding="3" cellspacing="0" border="1" align="center" dir="rtl">
        <thead>
        	 <tr>
             	<th colspan="23" align="center"><strong>رواتب مؤسسة ابن جبرين الخيرية لشهر <?=$mnt['ar_month_name']?> لعام <?=preg_replace('/\D/', '', $pln['plan_title'])?> هـ</strong></th>
             </tr>
             <tr>
                <th rowspan="3" align="center" valign="bottom">م.</th>
                <th rowspan="3" align="center" valign="bottom">الاسم</th>
                <th rowspan="3" align="center" valign="bottom">الوظيفة</th>
                <th rowspan="3" align="center" valign="bottom">الكود</th>
                <th colspan="11" align="center" valign="bottom">إستحقاقات</th>
                <th colspan="7" align="center" valign="bottom">إستقطاعات</th>
                <th rowspan="2" align="center" valign="bottom">الصافي</th>
             </tr>
             <tr>
             	<th align="center" valign="bottom">الراتب</th>
                <th colspan="6" align="center" valign="bottom">البدلات</th>
                <th rowspan="2" align="center" valign="bottom">إضافي</th>
                <th rowspan="2" align="center" valign="bottom">أخرى</th>
                <th align="center" valign="bottom">التأمينات</th>
                <th rowspan="2" align="center" valign="bottom">الإجمالي</th>
                <th align="center" valign="bottom">تأخيرات</th>
                <th rowspan="2" align="center" valign="bottom">سلف</th>
                <th rowspan="2" align="center" valign="bottom">أخرى</th>
                <th colspan="3" align="center" valign="bottom">التأمينات</th>
                <th rowspan="2" align="center" valign="bottom">الإجمالي</th>
             </tr>
             <tr>
                <th align="center" valign="bottom">الأساسي</th>
                <th align="center" valign="bottom">إنتقال</th>
                <th align="center" valign="bottom">سكن</th>
                <th align="center" valign="bottom">ندرة</th>
                <th align="center" valign="bottom">إنتداب</th>
                <th align="center" valign="bottom">تكليف</th>
                <th align="center" valign="bottom">تميز</th>
                <th align="center" valign="bottom">المؤسسة</th>
                <th align="center" valign="bottom">غياب</th>
                <th align="center" valign="bottom">الفرد</th>
                <th align="center" valign="bottom">المؤسسة</th>
                <th align="center" valign="bottom">الإجمالي</th>
                <th align="center" valign="bottom">المستحق</th>
             </tr>
        </thead>
        <tbody>
        	<?php
            $i   = 1; 
			$tin = 0;
			$tou = 0;
			$tis = 0;
			$x01 = 0;
			$x02 = 0;
			$x03 = 0;
			$x04 = 0;
			$x05 = 0;
			$x06 = 0;
			$x07 = 0;
			$x08 = 0;
			$x09 = 0;
			$x10 = 0;
			$x11 = 0;
			$x12 = 0;
			$x13 = 0;
			$x14 = 0;
			$x15 = 0;
			$x16 = 0;
			$x17 = 0;
			$x18 = 0;
			$x19 = 0;
			foreach($msh as $r){ 
				$int = $r['basic'] + $r['badal_transport'] + $r['badal_housing'] + $r['badal_worknature'] + $r['badal_entedab'] + $r['badal_takleef'] + $r['badal_communication'] + $r['extras'] + $r['awards'] + $r['iso'];
				$out = $r['delays'] + $r['loans'] + $r['discounts'] + $r['isp'] + $r['iso'];
				$ist = $r['isp'] + $r['iso'];
				$stf = getStaff($r['staff_id']);
				$tot = $int - $out;
				$x01 += $r['basic'];
				$x02 += $r['badal_transport'];
				$x03 += $r['badal_housing'];
				$x19 += $r['badal_worknature'];
				$x04 += $r['badal_entedab'];
				$x05 += $r['badal_takleef'];
				$x06 += $r['badal_communication'];
				$x07 += $r['extras'];
				$x08 += $r['awards'];
				$x09 += $r['iso'];
				$x10 += $int;
				$x11 += $r['delays'];
				$x12 += $r['loans'];
				$x13 += $r['discounts'];
				$x14 += $r['isp'];
				$x15 += $r['iso'];
				$x16 += $ist;
				$x17 += $out;
				$x18 += $tot;
			?>
            <tr>
            	<td align="center" valign="middle"><?=$i?></td>
                <td align="center" valign="middle"><?=$stf[0]['staff_fullname']?></td>
                <td align="center" valign="middle"><?=$stf[0]['job_title']?></td>
                <td align="center" valign="middle"><?=$stf[0]['job_code']?></td>
                <td align="center" valign="middle" style="background-color:#0F0; color:#000;"><strong><?=number_format($r['basic'], 2, '.', ',')?></strong></td>
                <td align="center" valign="middle"><?=number_format($r['badal_transport'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['badal_housing'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['badal_worknature'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['badal_entedab'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['badal_takleef'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['badal_communication'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['extras'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['awards'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['iso'], 2, '.', ',')?></td>
                <td align="center" valign="middle" style="background-color:#CCC; color:#060;"><strong><?=number_format($int, 2, '.', ',')?></strong></td>
                <td align="center" valign="middle"><?=number_format($r['delays'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['loans'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['discounts'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['isp'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($r['iso'], 2, '.', ',')?></td>
                <td align="center" valign="middle"><strong><?=number_format($ist, 2, '.', ',')?></strong></td>
                <td align="center" valign="middle" style="background-color:#CCC; color:#600;"><strong><?=number_format($out, 2, '.', ',')?></strong></td>
                <td align="center" valign="middle" style="background-color:#0F0; color:#000;"><strong><?=number_format($tot, 2, '.', ',')?></strong></td>
            </tr>
            <?php $i++; ?>
            <?php } ?>
            <tr>
                <td align="center" valign="middle" colspan="4">الإجمالي:</td>
                <td align="center" valign="middle" style="background-color:#0F0; color:#000;"><strong><?=number_format($x01, 2, '.', ',')?></strong></td>
                <td align="center" valign="middle"><?=number_format($x02, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x03, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x19, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x04, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x05, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x06, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x07, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x08, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x09, 2, '.', ',')?></td>
                <td align="center" valign="middle" style="background-color:#CCC; color:#060;"><strong><?=number_format($x10, 2, '.', ',')?></strong></td>
                <td align="center" valign="middle"><?=number_format($x11, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x12, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x13, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x14, 2, '.', ',')?></td>
                <td align="center" valign="middle"><?=number_format($x15, 2, '.', ',')?></td>
                <td align="center" valign="middle"><strong><?=number_format($x16, 2, '.', ',')?></strong></td>
                <td align="center" valign="middle" style="background-color:#CCC; color:#600;"><strong><?=number_format($x17, 2, '.', ',')?></strong></td>
                <td align="center" valign="middle" style="background-color:#0F0; color:#000;"><strong><?=number_format($x18, 2, '.', ',')?></strong></td>
            </tr>
        </tbody>
        <tfoot>
        	<tr>
            	<td colspan="23" align="center" valign="middle"><strong>فقط <?=str_replace(" و صفر هللة", "", $Arabic->money2str($x18, 'SAR', 'ar'))?> لاغير.</strong></td>
            </tr>
           <tr>
                <td colspan="23" style="border:none !important;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" align="center" valign="middle" style="border:none !important;"><strong>المحاسب</strong></td>
                <td colspan="9" align="center" valign="middle" style="border:none !important;"><strong>المدير المالي</strong></td>
                <td colspan="9" align="center" valign="middle" style="border:none !important;"><strong>المشرف العام</strong></td>
            </tr>
            <tr>
                <td colspan="5" align="center" valign="middle" style="border:none !important;">&nbsp;</td>
                <td colspan="9" align="center" valign="middle" style="border:none !important;">&nbsp;</td>
                <td colspan="9" align="center" valign="middle" style="border:none !important;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" align="center" valign="middle" style="border:none !important;"><strong>باسم محمد عبدالعظيم محمود</strong></td>
                <td colspan="9" align="center" valign="middle" style="border:none !important;"><strong>محمد بن عبدالله الجبرين</strong></td>
                <td colspan="9" align="center" valign="middle" style="border:none !important;"><strong>د/ عبدالرحمن بن عبدالله الجبرين</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>