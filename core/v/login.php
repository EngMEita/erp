<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$gs['org_title']?> :: تسجيل الدخول</title>

    <link href="<?=$baseUrl?>temp/enjez/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$baseUrl?>temp/enjez/css/metisMenu.min.css" rel="stylesheet">
    <link href="<?=$baseUrl?>temp/enjez/css/admin.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=$baseUrl?>temp/enjez/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="login">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <img class="profile-img" src="<?=$baseUrl?>temp/enjez/img/logo-bg.png" alt="">
                    <h1 class="text-center login-title">تسجيل الدخول</h1>
                    <form class="form-signin" action="index.php?a=login" method="post">
                    <input type="text" name="un" id="un" class="form-control" placeholder="اسم المستخدم" required autofocus>
                    <input type="password" name="pw" id="pw" class="form-control" placeholder="كلمة المرور" required>
                    <input type="hidden" name="url" value="<?=$url?>" />
                    <button class="btn btn-lg btn-primary btn-block" type="submit">دخـول</button>
                    <div class="text-center need-help"><a href="#">نسيت كلمة المرور؟ </a></div>
                    <span class="clearfix"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- jQuery -->
    <script src="<?=$baseUrl?>temp/enjez/js/jquery-admin.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$baseUrl?>temp/enjez/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$baseUrl?>temp/enjez/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?=$baseUrl?>temp/enjez/js/admin.js"></script>

</body>

</html>
