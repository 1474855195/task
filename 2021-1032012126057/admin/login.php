<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
if(is_admin_login($link)){
    skip('father_module.php','ok','您已经登录，请不要重复登录');
}
if(isset($_POST['submit'])){
    include_once 'inc/check_login_inc.php';
    escape($link, $_POST);
    $password=md5($_POST['pw']);
    $query="select * from admin where name='{$_POST['name']}' and pw='{$password}'";
    $result=execute($link, $query);
    if(mysqli_num_rows($result)==1){
        $data=mysqli_fetch_assoc($result);
        $_SESSION['admin']['name']=$data['name'];
        $_SESSION['admin']['pw']=$data['pw'];
        $_SESSION['admin']['id']=$data['id'];
        skip("father_module.php",'ok','登录成功');
    }else{
        skip('login.php','error','登陆失败');
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<style type="text/css">
body {
	background:#f7f7f7;
	font-size:14px;
}
#main {
	width:360px;
	height:320px;
	background:#fff;
	border:1px solid #ddd;
	position:absolute;
	top:50%;
	left:50%;
	margin-left:-180px;
	margin-top:-160px;
}
#main .title {
	height: 48px;
	line-height: 48px;
	color:#333;
	font-size:16px;
	font-weight:bold;
	text-indent:30px;
	border-bottom:1px dashed #eee;
}
#main form {
	width:300px;
	margin:20px 0 0 40px;
}
#main form label {
	margin:10px 0 0 0;
	display:block;
}
#main form label input.text {
	width:200px;
	height:25px;
}
#main form label .vcode {
	display:block;
	margin:0 0 0 56px;
}
#main form label input.submit {
	width:200px;
	display:block;
	height:35px;
	cursor:pointer;
	margin:0 0 0 56px;
}
</style>
</head>
<body>
	<div id="main">
		<div class="title">学生综合素质评测系统</div>
		<form method="post">
			<label>用户名：<input class="text" type="text" name="name" /></label>
			<label>密　码：<input class="text" type="password" name="pw" /></label>
			<label>验证码：<input class="text" type="text" name="vcode" /></label>
			<label><img class="vcode" src="../front/show_vcode.php" /></label>
			<label><input class="submit" type="submit" name="submit" value="登录" /></label>
		</form>
	</div>
</body>
</html>