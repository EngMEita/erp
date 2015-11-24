<?php

require_once($rootPath."core/m/global.php");
require_once($rootPath."core/m/users.php");
$url = urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$gs = getSettings();
if(isset($_GET['a']) && $_GET['a'] != ''){
	switch($_GET['a']){
		case 'login':
			$un = $_POST['un'];
			$pw = $_POST['pw'];
			if(log_me_in($un, $pw) != true) RedirWM(urldecode($_POST['url']), "خطأ في اسم الدخول أو كلمة المرور؟!!");
			else Redir(urldecode($_POST['url']));
		break;
		case 'logout':
			log_me_out();
			Redir("index.php");
		break;
		case 'logoutas':
			log_out_as();
			Redir("index.php");
		break;
		case 'forget':
		
		break;
		case 'login_as':
			if(isset($_GET['staff_id']) && intval($_GET['staff_id']) > 0 && ( in_array('acp', $_SESSION['staff']['rolls']) || in_array('acp', $_SESSION['my_data']['rolls']) )){
				if(log_in_as(intval($_GET['staff_id'])) != true) RedirWM(urldecode($_POST['url']), "لا يسمح بالدخول لهذا الموظف!");
				else Redir("index.php");
			}else Redir(urldecode($_POST['url']));
		break;
	}
}

if(!is_logged_in()){
	include_once($rootPath."core/v/login.php");
	die();	
}
?>