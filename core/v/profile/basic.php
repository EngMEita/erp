<style type="text/css">
.wImageCont img{ max-width:300px; height:auto; border-radius: 10px; border: 2px solid #666666; }
.hImageCont img{ max-height:300px; width:auto; border-radius: 10px; border: 2px solid #666666; }
</style>                        
                        <table class="table no-footer">
                            <tbody>
                            	<tr role="row">
                                    <td width="150px" align="left" valign="middle"><strong>الاسم</strong>: </td>
                                    <td valign="middle"><?=$staff[0]['staff_fullname']?></td>
									<?php if($staff[0]['staff_image'] != "" && file_exists("uploads/".$staff[0]['staff_image'])){ ?>                                  
                                    <td rowspan="8" width="0" align="center" valign="middle">
                                    	<div class="wImageCont">
                                    	<img src="<?=$baseUrl?>uploads/<?=$staff[0]['staff_image']?>" alt="<?=$staff[0]['staff_shortname']?>">
                                        </div>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>الهوية</strong>: </td>
                                    <td valign="middle">	
                                    	<?=$staff[0]['staff_ssid']?> - الإنتهاء: <?=$staff[0]['staff_ssid_exdate_full']?> ( بعد <?=$staff[0]['ssid_months']?> شهر )
                                        <?php if($staff[0]['staff_ssid_image'] != "" && file_exists("uploads/".$staff[0]['staff_ssid_image'])){ ?>
                                        <div class="hImageCont"><br /><img src="<?=$baseUrl?>uploads/<?=$staff[0]['staff_ssid_image']?>" alt="<?=$staff[0]['staff_ssid']?>"></div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>الوظيفة</strong>: </td>
                                    <td valign="middle"><?=$staff[0]['job_title']?> ب<?=$staff[0]['dept_name']?></td>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>الجوال</strong>: </td>
                                    <td valign="middle"><?=$staff[0]['staff_mobile']?></td>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>البريد الإلكتروني</strong>: </td>
                                    <td valign="middle"><a href="mailto:<?=$staff[0]['staff_email']?>" target="_blank"><?=$staff[0]['staff_email']?></a></td>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>الجنسية</strong>: </td>
                                    <td valign="middle"><?=$staff[0]['country_nationality']?></td>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>الكفيل</strong>: </td>
                                    <td valign="middle"><?=$staff[0]['kafeel_name']?> <?php if($staff[0]['kafala'] != ""){ ?>( <?=$staff[0]['kafala']?> )<?php } ?></td>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>تاريخ الميلاد</strong>: </td>
                                    <td valign="middle"><?=$staff[0]['staff_birthdate_full']?> ( <?=$staff[0]['staff_age']?> سنة )</td>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>العنوان</strong>: </td>
                                    <td valign="middle"><?=$staff[0]['staff_address']?></td>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>رصيد الإجازات</strong>: </td>
                                    <td valign="middle"><a href="index.php?c=hcp-staffvacations"><?=$svb?> يوم</a></td>
                                </tr>
                                <tr role="row">
                                	<td width="150px" align="left" valign="middle"><strong>تاريخ التعيين</strong>: </td>
                                    <td valign="middle"><?=formatDate($staff[0]['contract_date'], "dd MM yyyy T")?> ( منذ <?=$staff[0]['service_duration']['years']?> سنة و <?=$staff[0]['service_duration']['months']?> شهر و <?=$staff[0]['service_duration']['days']?> يوم )</td>
                                </tr>
                            </tbody>
                        </table>
