<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
$member_sid=is_login($link);
if(isset($_POST['submit'])){
    include 'inc/check_pw_update_inc.php';
    $password=md5($_POST['pw']);
    $query="update member set pw='{$password}' where sid={$_POST['sid']}";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        skip("index.php","ok","恭喜您修改成功");
    }else{
        skip('password_update.php','error','修改失败，请重试!');
    }
}
$template['title']='用户信息修改页';
$template['css']=array('style/public.css','style/register.css');
?>
<?php include_once 'inc/front_header_inc.php' ?>
<div id="register" class="auto">
	<h2>请输入信息</h2>
	<form method="post">
		<label>学工号：<input type="text" name="sid" /><span>*学号名不得为空，长度为8个字符</span></label>
		<label>新密码：<input type="password" name="pw" /><span>*密码不得少于6位</span></label>
		<label>确认密码：<input type="password" name="confirm_pw" /><span>*请再次输入密码</span></label>
		<label>验证码：<input name="vcode" name="vcode" type="text"  /><span>*请输入下方验证码</span></label>
		<img class="vcode" src="show_vcode.php" />
		<div style="clear:both;"></div>
		<input class="btn" name="submit" type="submit" value="确定修改" />
	</form>
</div>
<?php include_once 'inc/front_footer_inc.php' ?>