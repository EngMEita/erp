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
    <link href="<?=$baseUrl?>temp/enjez/css/metisMenu.min.css" rel="stylesheet">
    <link href="<?=$baseUrl?>temp/enjez/css/admin.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=$baseUrl?>temp/enjez/css/font-awesome.min.css">
    
    <!-- jQuery -->
    <script src="<?=$baseUrl?>temp/enjez/js/jquery-admin.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$baseUrl?>temp/enjez/js/bootstrap.min.js"></script>

    <!-- datatable -->
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>temp/datatable/css/jquery.dataTables.css">
	<script type="text/javascript" language="javascript" src="<?=$baseUrl?>temp/datatable/js/jquery.dataTables.js"></script>
    
    <!-- jquery rte editor -->
    <link type="text/css" rel="stylesheet" href="<?=$baseUrl?>temp/rte/jquery.rte.css" />
    <script type="text/javascript" src="<?=$baseUrl?>temp/rte/jquery.rte.js"></script>
    <script type="text/javascript" src="<?=$baseUrl?>temp/rte/jquery.rte.tb.js"></script>
    <script type="text/javascript" src="<?=$baseUrl?>temp/rte/jquery.ocupload-1.1.4.js"></script>
    
    <!-- autocomplete with multiselect -->
    <script type="text/javascript" src="<?=$baseUrl?>temp/acms/src/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="<?=$baseUrl?>temp/acms/styles/token-input.css" type="text/css" />
    <link rel="stylesheet" href="<?=$baseUrl?>temp/acms/styles/token-input-facebook.css" type="text/css" />
    
    <!-- thickbox -->
	<script type="text/javascript" src="<?=$baseUrl?>temp/thickbox/thickbox.js"></script>
    <link rel="stylesheet" href="<?=$baseUrl?>temp/thickbox/thickbox.css" type="text/css" media="screen" />
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$baseUrl?>temp/enjez/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?=$baseUrl?>temp/enjez/js/admin.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->    
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?=$gs['org_title']?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> ( <?=$msg?> ) <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                    	<?php $counter = 0; ?>
                    	<?php foreach($ims as $im){ ?>
                        <li>
                            <a href="index.php?c=messages&mod=read&id=<?=$im['data']['id']?>">
                                <div>
                                    <strong><?=Fld("staff", "staff_id", $im['content']['staff_id'], "staff_fullname")?></strong>
                                    <span class="pull-left text-muted">
                                        <em>( <?=formatDate(innerDate($im['content']['message_date']), "yyyy/mm/dd T")?> )</em>
                                    </span>
                                </div>
                                <div><?=$im['content']['message_title']?></div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <?php $counter++; ?>
                        <?php if($counter >= 4) break; ?>
                        <?php } ?>
                        <li><a href="index.php?c=messages&mod=new"><i class="fa fa-newspaper-o"></i> <strong>الرسائل الجديدة</strong></a></li>
                        <li><a href="index.php?c=messages&mod=all"><i class="fa fa-list-ol"></i> <strong>جميع الرسائل</strong></a></li>
                        <li><a href="index.php?c=messages&mod=archive"><i class="fa fa-archive"></i> <strong>أرشيف الرسائل</strong></a></li>
                        <li><a href="index.php?c=messages&mod=sent"><i class="fa fa-comment-o"></i> <strong>الرسائل المرسلة</strong></a></li>
                        <li class="divider"></li>
                        <li><a href="index.php?c=messages&mod=compose"><i class="fa fa-plus-square-o"></i> <strong>رسالة جديدة</strong></a></li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="index.php?c=profile"><i class="fa fa-user fa-fw"></i> <?=$_SESSION['staff']['staff_shortname']?></a></li>
                        <li><a href="index.php?c=acp-editstaff&staff_id=<?=$_SESSION['staff']['staff_id']?>&t=l"><i class="fa fa-gear fa-fw"></i> إعدادات الدخول</a></li>
                        <li><a href="index.php?c=acp-editstaff&staff_id=<?=$_SESSION['staff']['staff_id']?>&t=p"><i class="fa fa-gear fa-fw"></i> الإعدادات الشخصية</a></li>
                        <li class="divider"></li>
                        <li><a href="index.php?a=logout"><i class="fa fa-sign-out fa-fw"></i> تسجيل الخروج</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="logo"><img src="<?=$baseUrl?>temp/enjez/img/logo-s.png" class="img-responsive" /></div>
                <div id="time_now" class="date_day"></div>
                <div class="date_day"><?=$weekday?></div>
                <div class="date_day"><?=$th['y']?>/<?=$th['m']?>/<?=$th['d']?> <?=$th['T']?></div>
                <div class="date_day"><?=$ta['y']?>/<?=$ta['m']?>/<?=$ta['d']?> <?=$ta['T']?></div>
                <div style="display:block; width:100%; height:0px; clear:both;"></div>
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    	<li><a href="index.php"><i class="fa fa-home"></i> الرئيسية</a></li>
                        <!-- <li><a href="index.php?c=hcp-staffvacations"><i class="fa fa-check-circle-o"></i> الإجازات<?php if($intf){ echo " ( ".$ivcs." ) "; } ?></a></li>
        				<li><a href="index.php?c=hcp-leaves"><i class="fa fa-check-circle-o"></i> الأذونات<?php if($intf){ echo " ( ".$ilvs." ) "; } ?></a></li>
                        <li><a href="index.php?c=salary"><i class="fa fa-dollar"></i> بيان الراتب</a></li> -->
					<?php
                    foreach($_SESSION['staff']['rolls'] as $roll){
                        include("menu/".$roll.".php");
                    }
                    ?>
                	</ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>