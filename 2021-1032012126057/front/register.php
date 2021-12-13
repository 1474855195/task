<?php 
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
$member_sid=is_login($link);
/*if($member_sid){
    skip('index.php','error','您已经登录，请不要重复注册!');   
}*/
$member_sid=is_login($link);
if(isset($_POST['submit'])){
    include 'inc/check_register_inc.php';
    if($_POST['identity']=='教师'){
        $query="insert into son_charger(sid,name) values('{$_POST['sid']}','{$_POST['name']}')";
        execute($link, $query);
    }
    $query="insert into member(sid,name,pw,register_time,sex,identity,tel,dean,year) values('{$_POST['sid']}','{$_POST['name']}',md5('{$_POST['pw']}'),now(),'{$_POST['sex']}','{$_POST['identity']}','{$_POST['tel']}','{$_POST['dean']}',{$_POST['year']})";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        setcookie('member[sid]',$_POST['sid']);
        setcookie('member[name]',$_POST['name']);
        setcookie('member[pw]',md5($_POST['pw']));
        skip("index.php","ok","恭喜您注册成功");
    }else{
        skip('register.php','error','注册失败，请重试!');
    }
}
$template['title']='注册页';
$template['css']=array('style/public.css','style/register.css');
?>
<?php include_once 'inc/front_header_inc.php' ?>
<div id="register" class="auto">
	<h2>请注册</h2>
	<form method="post">
		<label>学工号：<input type="text" name="sid" /><span>*学号名不得为空，长度不得超过11个字符</span></label>
		<label>姓名：<input type="text" name="name" /><span>*姓名不得为空，长度不得超过32个字符</span></label>
		<label>性别：
				<select style="width:236px;height:25px;" name="sex">
					<option value="男">男</option>
					<option value="女">女</option>
				</select>
				<span>*请选择您的性别</span>
		</label>
		<label>身份：
				<select style="width:236px;height:25px;" name="identity">
					<option value="学生">学生</option>
					<option value="教师">教师</option>
				</select>
				<span>*请选择您的身份</span>
		</label>
		<label>所属单位：
				<select style="width:236px;height:25px;" name="dean">
					<option value="">---请选择一个学院---</option>
					<option value="智慧教育学院">智慧教育学院</option>
					<option value="文学院">文学院</option>
					<option value="商学院">商学院</option>
					<option value="外国语学院">外国语学院</option>
					<option value="地测学院">地测学院</option>
					<option value="数统学院">数统学院</option>
					<option value="美术学院">美术学院</option>
					<option value="音乐学院">音乐学院</option>
					<option value="马克思学院">马克思学院</option>
					<option value="历旅学院">历旅学院</option>
					<option value="化学学院">化学学院</option>
					<option value="机电学院">机电学院</option>
					<option value="物理学院">物理学院</option>
					<option value="生物学院">生物学院</option>
					<option value="传媒学院">传媒学院</option>
				</select>
				<span>*请选择您的学院</span>
		</label>
		<label>入学/入职年份：
				<select style="width:236px;height:25px;" name="year">
					<option value=2016>2016</option>
					<option value=2017>2017</option>
					<option value=2018>2018</option>
					<option value=2019>2019</option>
					<option value=2020>2020</option>
					<option value=2021>2021</option>
					<option value=2022>2022</option>
					<option value=2023>2023</option>
					<option value=2024>2024</option>
				</select>
				<span>*请选择您的入学年份</span>
		</label>
		<label>联系方式：<input type="text" name="tel" /><span>*联系方式不得为空，长度不得超过11个字符</span></label>
		<label>密码：<input type="password" name="pw" /><span>*密码不得少于6位</span></label>
		<label>确认密码：<input type="password" name="confirm_pw" /><span>*请再次输入密码</span></label>
		<label>验证码：<input name="vcode" name="vcode" type="text"  /><span>*请输入下方验证码</span></label>
		<img class="vcode" src="show_vcode.php" />
		<div style="clear:both;"></div>
		<input class="btn" name="submit" type="submit" value="确定注册" />
	</form>
</div>
<?php include_once 'inc/front_footer_inc.php' ?>