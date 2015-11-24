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
<table width="300" border="0" cellspacing="5" cellpadding="5">
  <tr>
  	<td width="10" rowspan="5">&nbsp;</td>
    <td colspan="4" align="center"><br /><strong>دوامات شهر <?=$m[0]['ar_month_name']?> في <?=$m[0]['plan_title']?></strong><br /><br /></td>
    <td width="10" rowspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>العنوان</strong></td>
    <td><strong>حضور</strong></td>
    <td><strong>إنصراف</strong></td>
    <td><input type="button" name="close" value="إغلاق" onclick="self.parent.tb_remove()" /></td>
  </tr>
  <?php foreach($wss as $ws){ ?>
  <?php if(isset($_GET['sid']) && intval($_GET['sid']) == $ws['shift_id']){ ?>
  <form action="index.php?c=workshifts&mid=<?=intval($_GET['mid'])?>" method="post">
	<input type="hidden" name="sid" value="<?=$ws['shift_id']?>" />
	<input type="hidden" name="act" value="edit" />
  <tr>
    <td><input type="text" name="title" value="<?=$ws['shift_title']?>" required size="20" /></td>
    <td><input type="text" name="in" value="<?=$ws['shift_in']?>" placeholder="08:00" required size="4" /></td>
    <td><input type="text" name="out" value="<?=$ws['shift_out']?>" placeholder="17:00" required size="4" /></td>
    <td><input type="submit" name="save" value="حفظ" /></td>
  </tr>
  </form>
  <?php }else{ ?>
  <tr>
    <td><a href="index.php?c=workshifts&mid=<?=intval($_GET['mid'])?>&sid=<?=$ws['shift_id']?>"><?=$ws['shift_title']?></a></td>
    <td><?=$ws['shift_in']?></td>
    <td><?=$ws['shift_out']?></td>
    <td><a href='index.php?c=workshifts&mid=<?=intval($_GET['mid'])?>&delete=<?=$ws['shift_id']?>'>حذف</a></td>
  </tr>
  <?php } ?>
  <?php } ?>
  <?php if(!isset($_GET['sid'])){ ?>
  <form action="index.php?c=workshifts&mid=<?=intval($_GET['mid'])?>" method="post">
	<input type="hidden" name="mid" value="<?=intval($_GET['mid'])?>" />
	<input type="hidden" name="act" value="add" />
  <tr>
    <td><input type="text" name="title" value="" required size="40" /></td>
    <td><input type="text" name="in" value="" placeholder="08:00" required size="5" /></td>
    <td><input type="text" name="out" value="" placeholder="17:00" required size="5" /></td>
    <td><input type="submit" name="save" value="حفظ" /></td>
  </tr>
  </form>
  <?php } ?>
  </tr>
</table>
</body>
</html>