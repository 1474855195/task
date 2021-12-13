<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
if(isset($_POST['submit'])){
    include 'inc/check_son_module_inc.php';
    $query="insert into son_module(id,father_module_id,module_name,info,member_id,son_charger) values({$_POST['id']},{$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},'{$_POST['son_charger']}')";
    execute($link, $query);
    $query1="insert into son_charger(sid,name,mid) values({$_POST['member_id']},'{$_POST['son_charger']}',{$_POST['id']})";
    execute($link, $query1);
    if(mysqli_affected_rows($link)==1){
        skip('father_module.php','ok','恭喜您添加成功');
    }else{
        skip('father_module_add.php','error','添加失败，请重试！');
    }
}
$template['title']='社团添加';
$template['css']=array('style/public.css');
?>

<?php include 'inc/header_inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 30px">社团添加</div>
	<form method="post">
    	<table class="au">
    		<tr>
    			<td>社团序号</td>
    			<td><input name="id" type="text" /></td>
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
        				        echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
        				    }
        				?>
        			</select>
        		</td>
        		<td>
        			必须选择一个所属的学校部门
        		</td>
        	</tr>
    		<tr>
    			<td>社团名称</td>
    			<td><input name="module_name" type="text" /></td>
    			<td>
    				社团名称不能为空，最大不能超过255个字符
    			</td>
    		</tr>
    		<tr>
    			<td>社团简介</td>
    			<td><textarea name="info"></textarea></td>
    			<td>
    				社团不能最大不能超过255个字
    			</td>
    		<tr>
    			<td>社团负责人学工号</td>
    			<td><input name="member_id" type="text" /></td>
    			<td>
    				社团负责人学号不能为空，最大不能超过8位数
    			</td>
    		</tr>
        	<tr>
    			<td>社团负责人姓名</td>
    			<td><input name="son_charger" type="text" /></td>
    			<td>
    				社团负责人姓名不能为空，最大不能超过255个字符
    			</td>
    		</tr>
    	</table>
	<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
	</form>
</div>
<?php include 'inc/footer_inc.php' ?>	