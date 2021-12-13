<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
$template['title']='综合素质测评系统后台管理员界面';
$template['css']=array('style/public.css');
?>
<?php include 'inc/header_inc.php' ?>
<div id="main" >
	<div class="title">学校部门列表</div>
	<table class="list">
		<tr>
			<th>序号</th>	 	 	
			<th>部门名称</th>
			<th>负责人</th>
			<th>操作</th>
		</tr>
		<?php 
		$query="select * from father_module";
		$result=execute($link, $query);
		while($data=mysqli_fetch_assoc($result)){
		    $url=urlencode("father_module_delete.php?id={$data['id']}");
		    $return_url=urlencode($_SERVER['REQUEST_URI']);
		    $message="你真的要删除{$data['module_name']}吗？";
		    $delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html=<<<A
    		 <tr>
    			<td>{$data['id']}</td>
    			<td>{$data['module_name']}</td>
    			<td>{$data['charger']}</td>
    			<td><a href="father_module_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href=$delete_url>[删除]</a></td>
    		</tr>
A;
            echo $html;
		}
		?>		
	</table>
</div>
<?php include 'inc/footer_inc.php' ?>	
