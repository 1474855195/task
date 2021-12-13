<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';

$template['title']='社团修改界面';
$template['css']=array('style/public.css');

$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('son_module_update.php','error','id参数错误！');
}
$query="select * from son_module where id={$_GET['id']}";
$result=execute($link, $query);
if(!mysqli_num_rows($result)){
    skip('son_module_update.php','error','这条记录不存在');
}
$data=mysqli_fetch_assoc($result);
if(isset($_POST['submit'])){
    include 'inc/check_son_module_inc.php';
    $query="update son_module set 
    id={$_POST['id']},
    father_module_id={$_POST['father_module_id']},
    module_name='{$_POST['module_name']}',
    info='{$_POST['info']}',
    member_id={$_POST['member_id']},
    son_charger='{$_POST['son_charger']}' 
    where id={$_GET['id']}";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        skip('son_module.php','ok','恭喜您修改成功');
    }else{
        skip('son_module_update.php','error','修改失败，请重试！');
    }
}
?>
<?php include 'inc/header_inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 30px">社团信息编辑--<?php echo $data['module_name'] ?></div>
	<form method="post">
    	<table class="au">
    		<tr>
    			<td>社团序号</td>
    			<td><input name='id' value=<?php echo $data['id']?> type="text" /></td>
    			<td>
    				社团序号不能为空
    			</td>
    		</tr>
        	<tr>
        		<td>所属学校部门</td>
        		<td>
        			<select name='father_module_id'>
        				<option value="0">-----请选择一个学校部门-----</option>
        				<?php 
        				    $query="select * from father_module";
        				    $result_father=execute($link, $query);
        				    while($data_father=mysqli_fetch_assoc($result_father)){
        				        if($data['father_module_id']==$data_father['id']){
        				            echo "<option selected='selected' value={$data_father['id']}>{$data_father['module_name']}</option>";
        				        }else{
        				            echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
        				        }
        				    }
        				?>
        			</select>
        		</td>
        		<td>
        			必须选择一个所属的学校部门
        		</td>
        	</tr>
    		<tr>
    			<td>社团名称/职务</td>
    			<td><input name="module_name" value=<?php echo $data['module_name']?> type="text" /></td>
    			<td>
    				社团名称不能为空，最大不能超过255个字符
    			</td>
    		</tr>
    		<tr>
    			<td>社团简介</td>
    			<td><textarea name="info" ></textarea></td>
    		<tr>
    			<td>社团负责人学号</td>
    			<td><input name="member_id" value=<?php echo $data['member_id']?> type="text" /></td>
    			<td>
    				社团负责人学号不能为空，最大不能超过8位数
    			</td>
    		</tr>
        	<tr>
    			<td>社团负责人姓名</td>
    			<td><input name="son_charger" value=<?php echo $data['son_charger']?> type="text" /></td>
    			<td>
    				社团负责人姓名不能为空，最大不能超过255个字符
    			</td>
    		</tr>
    	</table>
	<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
	</form>
</div>
<?php include 'inc/footer_inc.php' ?>	