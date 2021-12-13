<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';

$link=connect();
$member_sid=is_login($link);
if(!$member_sid){
   skip('login.php','error','请登录后再发布活动！'); 
}
$query="select * from son_charger where sid={$member_sid} ";
$result=execute($link, $query);
if(!mysqli_affected_rows($link)){
    skip('login.php','error','仅社团负责人/教师可发布活动！'); 
}
if(isset($_POST['submit'])){
    include 'inc/check_publish_inc.php';
    $_POST=escape($link,$_POST);
    $query="insert into activity(module_id,title,content,time) values({$_POST['module_id']},'{$_POST['title']}','{$_POST['content']}',now())";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        skip('index.php','ok','恭喜您，发布成功');
    }else{
        skip('publish.php','error','发布失败，请重试！');
    }
}
$template['title']='活动发布页面';
$template['css']=array('style/public.css','style/publish.css');
?>
<?php include_once 'inc/front_header_inc.php' ?>
<div id="position" class="auto">
		 <a href="index.php">首页</a> &gt; 发布活动
	</div>
	<div id="publish">
		<form method="post">
			<select name="module_id">
			<option value="0">-----请选择一个社团-----</option>
					<?php 
					    $where='';
					    if(isset($_GET['father_module_id']) && is_numeric($_GET['father_module_id'])){
					           $where="where id={$_GET['father_module_id']}";
					    }
    				    $query="select * from father_module {$where}";
    				    $result_father=execute($link, $query);
    				    while($data_father=mysqli_fetch_assoc($result_father)){
    				       echo "<optgroup label='{$data_father['module_name']}'>";
    				       $query="select * from son_module where father_module_id={$data_father['id']}";
    				       $result_son=execute($link, $query);
    				       while($data_son=mysqli_fetch_assoc($result_son)){
    				           if(isset($_GET['son_module_id'])&&$_GET['son_module_id']==$data_son['id']){
    				               echo "<option selected='selected' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
    				           }else{
    				               echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
    				           }
    				       }
    				       echo "</optgroup>";
    				    }
    			     ?>
			</select>
			<input class="title" placeholder="请输入标题" name="title" type="text" />
			<textarea name="content" class="content"></textarea>
			<input class="btn" name="submit" type="submit" value="提交" />
			<div style="clear:both;"></div>
	</form>
</div>
<?php include_once 'inc/front_footer_inc.php' ?>