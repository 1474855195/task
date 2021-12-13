<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';

$template['title']='活动编辑界面';
$template['css']=array('style/public.css');

$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('son_module_update.php','error','id参数错误！');
}
$query="select * from activity where id={$_GET['id']}";
$result=execute($link, $query);
if(!mysqli_num_rows($result)){
    skip('activity_update.php','error','这条记录不存在');
}
$data=mysqli_fetch_assoc($result);
if(isset($_POST['submit'])){
    include 'inc/check_activity_update_inc.php';
    $query="update activity set
    id={$_POST['id']},
    module_id={$_POST['module_id']},
    title='{$_POST['title']}',
    content='{$_POST['content']}'
    where id={$_GET['id']}";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        skip('activity_manange.php','ok','恭喜您修改成功');
    }else{
        skip('activity_update.php','error','修改失败，请重试！');
    }
}
?>
<?php include 'inc/header_inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 30px">活动信息编辑--<?php echo $data['title'] ?></div>
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
        			<select name='module_id'>
        				<option value="0">-----请选择一个社团/职务-----</option>
        				<?php 
        				    $query="select * from son_module";
        				    $result_son=execute($link, $query);
        				    while($data_son=mysqli_fetch_assoc($result_son)){
        				        if($data['module_id']==$data_son['id']){
        				            echo "<option selected='selected' value={$data_son['id']}>{$data_son['module_name']}</option>";
        				        }else{
        				            echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
        				        }
        				    }
        				?>
        			</select>
        		</td>
        		<td>
        			必须选择一个所属的社团/职务
        		</td>
        	</tr>
    		<tr>
    			<td>活动名称</td>
    			<td><input name="title" value=<?php echo $data['title']?> type="text" /></td>
    			<td>
    				活动名称不能为空，最大不能超过255个字符
    			</td>
    		</tr>
    		<tr>
    			<td>活动简介</td>
    			<td><textarea name="content" ></textarea></td>
    	</table>
	<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
	</form>
</div>


<?php include 'inc/footer_inc.php' ?>	