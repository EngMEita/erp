<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$gs['org_title']?></title>

    <link href="<?=$baseUrl?>temp/enjez/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$baseUrl?>temp/enjez/css/admin.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=$baseUrl?>temp/enjez/css/font-awesome.min.css">
</head>
<body>
<form action="index.php?c=acp-rolls&staff_id=<?=$_GET['staff_id']?>" method="post">
<input type="hidden" name="staff_id" value="<?=$_GET['staff_id']?>" />
<input type="hidden" name="act" value="addRolls" />
<table width="400" border="0" cellspacing="10" cellpadding="10">
  <tr>
  	<td width="10" rowspan="5">&nbsp;</td>
    <td colspan="4" align="center"><br /><strong>صلاحيات الدخول لـ '<?=$staff[0]['staff_shortname']?>'</strong><br /><br /></td>
    <td width="10" rowspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="30"><input type="checkbox" name="rolls[]" value="acp"<?php if(in_array("acp", $staff[0]['staff_rolls'])){ ?> checked="checked"<?php } ?> /></td>
    <td>مدير نظام</td>
    <td width="30"><input type="checkbox" name="rolls[]" value="ccp"<?php if(in_array("ccp", $staff[0]['staff_rolls'])){ ?> checked="checked"<?php } ?> /></td>
    <td>الإدارة العليا</td>
  </tr>
  <tr>
    <td width="30"><input type="checkbox" name="rolls[]" value="hcp"<?php if(in_array("hcp", $staff[0]['staff_rolls'])){ ?> checked="checked"<?php } ?> /></td>
    <td>الشؤون الإدارية</td>
    <td width="30"><input type="checkbox" name="rolls[]" value="fcp"<?php if(in_array("fcp", $staff[0]['staff_rolls'])){ ?> checked="checked"<?php } ?> /></td>
    <td>الشؤون المالية</td>
  </tr>
  <tr>
    <td width="30"><input type="checkbox" name="rolls[]" value="dcp"<?php if(in_array("dcp", $staff[0]['staff_rolls'])){ ?> checked="checked"<?php } ?> /></td>
    <td>إدارة القسم</td>
    <td width="30"><input type="checkbox" name="rolls[]" value="scp"<?php if(in_array("scp", $staff[0]['staff_rolls'])){ ?> checked="checked"<?php } ?> /></td>
    <td>موظف</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
    	<input type="submit" name="addRolls" value="حفظ" />
    </td>
    <td colspan="2" align="center">
        <input type="button" name="close" value="إغلاق" onclick="self.parent.tb_remove()" />
    </td>
  </tr>
</table>
</form>
</body>
</html>