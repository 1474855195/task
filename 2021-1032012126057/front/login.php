<?php 
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
$member_sid=is_login($link);
if($member_sid){
    skip('index.php','error','您已经登录，请不要重复登录!');
}
if(isset($_POST['submit'])){
    include 'inc/check_login_inc.php';
    setcookie('member[sid]',$_POST['sid'],time()+3600);
}
$template['title']='欢迎登录';
$template['css']=array('style/public.css','style/register.css');
?>
<?php include_once 'inc/front_header_inc.php' ?>
<div id="register" class="auto">
	<h2>请登录</h2>
	<form method="post">
		<label>学工号：<input type="text" name="sid" /><span>*请输入学号</span></label>
		<label>密码：<input type="password" name="pw" /><span>*请输入密码</span></label>
		<label>验证码：<input name="vcode" type="text" name="vcode" /><span>*请输入下方验证码</span></label>
		<img class="vcode" src="show_vcode.php" />
		<div style="clear:both;"></div>
		<input class="btn" type="submit" name="submit" value="确定" />
	</form>
</div>
<?php include_once 'inc/front_footer_inc.php' ?>