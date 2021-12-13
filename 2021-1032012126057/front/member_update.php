<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
$member_sid=is_login($link);
if(isset($_POST['submit'])){
    include 'inc/check_member_update_inc.php';
    $query="update member set sid={$_POST['sid']},name='{$_POST['name']}',dean='{$_POST['dean']}',tel='{$_POST['tel']}' where sid={$_POST['sid']}";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        skip("index.php","ok","恭喜您修改成功");
    }else{
        skip('member_update.php','error','修改失败，请重试!');
    }
}
$template['title']='用户信息修改页';
$template['css']=array('style/public.css','style/register.css');
?>
<?php include_once 'inc/front_header_inc.php' ?>
<div id="register" class="auto">
	<h2>请输入信息</h2>
	<form method="post">
		<label>学工号：<input type="text" name="sid" /><span>*学号名不得为空，长度不得超过11个字符</span></label>
		<label>姓名：<input type="text" name="name" /><span>*姓名不得为空，长度不得超过32个字符</span></label>
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
		<label>联系方式：<input type="text" name="tel" /><span>*联系方式不得为空，长度不得超过11个字符</span></label>
		<div style="clear:both;"></div>
		<input class="btn" name="submit" type="submit" value="确定修改" />
	</form>
</div>
<?php include_once 'inc/front_footer_inc.php' ?>