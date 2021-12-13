<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
if(isset($_POST['submit'])){
    include 'inc/check_father_module_inc.php';
    $query="insert into father_module(id,module_name,charger) values({$_POST['id']},'{$_POST['module_name']}','{$_POST['charger']}')";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        skip('father_module.php','ok','恭喜您添加成功');
    }else{
        skip('father_module_add.php','error','添加失败，请重试！');
    }
}
$template['title']='学校部门添加界面';
$template['css']=array('style/public.css');
?>

<?php include 'inc/header_inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 30px">学校部门添加</div>
	<form method="post">
    	<table class="au">
    		<tr>
    			<td>部门序号</td>
    			<td><input name="id" type="text" /></td>
    			<td>
    				学校部门序号不能为空
    			</td>
    		</tr>
    		<tr>
    			<td>部门名称</td>
    			<td><input name="module_name" type="text" /></td>
    			<td>
    				学校部门不能为空，最大不能超过255个字符
    			</td>
    		</tr>
    		<tr>
    			<td>负责人</td>
    			<td><input name="charger" type="text" /></td>
    			<td>
    				负责人姓名不能为空，最大不能超过255个字符
    			</td>
    		</tr>
    	</table>
	<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
	</form>
</div>
<?php include 'inc/footer_inc.php' ?>	