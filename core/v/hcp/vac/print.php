<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>نموذج طلب إجازة</title>
<style type="text/css">
body {
    margin: 0;
    padding: 0;
    background-color: #FAFAFA;
    font-family: Arial, Helvetica, sans-serif;
	font-size:12pt;
	direction:rtl;
}
* {
	direction:rtl;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}
.page {
    width: 21cm;
    height: 29.7cm;
    padding: 0;
    margin: 0.5cm auto;
    border: 1px #000 solid;
    border-radius: 3px;
    background: white;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
}

@page {
    size: A4;
    margin: 0;
}

.header{
	padding:0.5cm;
	border: 1px #000 solid;
	border-radius: 3px;
}

@media print {
    .page {
        margin: auto;
		margin-top: 0.5cm;
		padding:0.5cm;
        border: 1px #000 solid;
    	border-radius: 3px;
        width: 20cm;
        height: 25.7cm;
        box-shadow: initial;
        background: initial;
    }
	.header{
		padding:0.5cm;
		border: 1px #000 solid;
		border-radius: 3px;
	}
}
</style>
<script type="text/javascript">
function printMe(){
	window.print();
	setTimeout(goBack(), 100);
}
function goBack(){
	window.location = 'index.php?c=hcp-staffvacations';	
}
</script>
</head>
<?php 
if(in_array("ccp", getStaffRolls($vac['staff_id']))){
	$to = "المشرف العام";
}else{
	$to = "المدير التنفيذي";
}
?>
<body onLoad="printMe();">
<div class="page">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3">
    	<div class="header">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            	<tr>
                	<td align="right" valign="bottom" width="35%" rowspan="2"><img alt="jebreen" src="<?=$baseUrl?>temp/enjez/img/j_jebreen_s.png" width="228" height="63" /></td>
                    <td align="center" valign="top" width="30%"><img alt="jebreen" src="<?=$baseUrl?>temp/enjez/img/j_basmala_s.png" width="88" height="57" /></td>
                    <td align="left" valign="top" width="35%" rowspan="2"><img alt="jebreen" src="<?=$baseUrl?>temp/enjez/img/j_logo_s.png" width="149" height="134" /></td>
                </tr>
                <tr>
                	<td align="center" valign="bottom"><h3 align="center" style="text-decoration:underline;">نموذج طلب إجازة</h3></td>
                </tr>
            </table>
        </div>
    </td>
  </tr>
  <tr>
    <td colspan="3">
    <p align="right" style="text-indent:2cm;"><strong><?=$to?> لمؤسسة ابن جبرين الخيرية - وفقه الله -</strong></p>
    <p align="center">السلام عليكم ورحمة الله وبركاته وبعد...</p>
    <p align="right" style="text-indent:1cm;">أرغب السماح لي <strong>بإجازة ( <?=$vacation_type['vacation_type_title']?> )</strong> وذلك لمدة ( <strong><?=$vac['vacation_duration']?> يوم</strong> ) اعتبارا من <strong><?=formatDate(innerDate($vac['vacation_startdate']), "yyyy/mm/dd T")?></strong></p>
    <p align="right" style="text-indent:1cm;">وسيكون عنواني أثناء الإجازة/ <strong><?=$vac['vacation_address']?></strong></p>
    <p align="right" style="text-indent:1cm;">ورقم الجوال المتاح/ <strong><span dir="ltr"><?=$vac['vacation_mobile']?></span></strong></p>
    <div style="float:left; display:block; width:50%; margin-left:10px;">
        <p align="center">مقدمه</p>
        <p align="center"><strong><?=$staff[0]['staff_fullname']?></strong></p>
        <p align="center">الوظيفة: <?=$staff[0]['job_title']?><br /><?=formatDate(innerDate($vac['vacation_applydate']), "yyyy/mm/dd T")?></p>
        <p align="center"><br />التوقيع: .......................................................</p>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="3">
    <p align="center"> ------------------------------------------------------ <strong><u>شؤون الموظفين</u></strong> ------------------------------------------------------ </p>
    <?php if($vacation_type['vacation_type_from_balance'] > 0 && $vac['vacation_balance'] > 0){ ?>
    <p align="center">رصيده المتاح حتى يوم طلب الإجازة ( <strong><?=$vac['vacation_balance']?> يوم</strong> )</p>
    <?php } ?>
    <?php if(is_array($last_vac)){ ?>
    <p align="center">آخر إجازة تمتع بها: ( <strong><?=$last_vac['vacation_type_title']?></strong> ) لمدة ( <strong><?=$last_vac['vacation_duration']?> يوم</strong> ) بتاريخ <strong><?=formatDate(innerDate($last_vac['vacation_startdate']), "yyyy/mm/dd T")?></strong></p>
    <?php } ?>
    <div style="float:left; display:block; width:50%; margin-left:10px;">
    	<p align="right"><br />التوقيع: ........................................................</p>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="3">
    <p align="center"> ------------------------------------------------------ <strong><u><?=$to?></u></strong> ------------------------------------------------------ </p>
    <div style="float:left; display:block; width:50%; margin-left:10px;">
    	<p align="right"><br />التوقيع: ........................................................</p>
    </div>
    </td>
  </tr>
</table>
</div>
</body>
</html>