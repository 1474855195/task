<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';

$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('father_module_update.php','error','id参数错误！');
}
$query="select * from father_module where id={$_GET['id']}";
$result=execute($link, $query);
if(!mysqli_num_rows($result)){
    skip('father_module_update.php','error','这条记录不存在');
}
if(isset($_POST['submit'])){
    include 'inc/check_father_module_inc.php';
    $query="update father_module set id={$_POST['id']},module_name='{$_POST['module_name']}',charger='{$_POST['charger']}' where id={$_GET['id']}";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        skip('father_module.php','ok','恭喜您修改成功');
    }else{
        skip('father_module_update.php','error','修改失败，请重试！');
    }
}
$data=mysqli_fetch_assoc($result);
$template['title']='学校部门编辑界面';
$template['css']=array('style/public.css');
?>
<?php include 'inc/header_inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 30px">学校部门信息编辑--<?php echo $data['module_name']?></div>
	<form method="post">
    	<table class="au">
        	<tr>
        			<td>部门序号</td>
        			<td><input name="id" value="<?php  echo $data{'id'} ?>" type="text" /></td>
        			<td>
        				部门序号不能为空
        			</td>
        	</tr>
    		<tr>
    			<td>部门名称</td>
    			<td><input name="module_name" value="<?php  echo $data{'module_name'} ?>" type="text" /></td>
    			<td>
    				学校部门不能为空，最大不能超过255个字符
    			</td>
    		</tr>
    		<tr>
    			<td>负责人</td>
    			<td><input name="charger" value=<?php  echo $data{'charger'} ?> type="text" /></td>
    			<td>
    				负责人姓名不能为空，最大不能超过255个字符
    			</td>
    		</tr>
    	</table>
	<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
	</form>
</div>
<?php include 'inc/footer_inc.php' ?>	