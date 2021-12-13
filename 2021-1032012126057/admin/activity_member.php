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
	<div class="title">用户列表</div>
	<table class="list">
		<tr>
			<th>社团编号</th>	 
			<th>活动名称</th>	 	 	
			<th>学号</th>
			<th>姓名</th>
			<th>操作</th>
		</tr>
		<?php 
		$query="select * from activity_member where activity_id={$_GET['id']}";
		$result=execute($link, $query);
		while($data=mysqli_fetch_assoc($result)){
		    $url=urlencode("activity_member_delete.php?id={$data['id']}");
		    $return_url=urlencode($_SERVER['REQUEST_URI']);
		    $message="你真的要删除{$data['name']}吗？";
		    $delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html=<<<A
    		 <tr>
    			<td>{$data['son_module_id']}</td>
                <td>{$data['activity_title']}</td>
    			<td>{$data['sid']}</td>
    			<td>{$data['name']}</td>
    			<td><a href=$delete_url>[删除]</a></td>
    		</tr>
A;
            echo $html;
		}
		?>		
	</table>
</div>
<?php include 'inc/footer_inc.php' ?>	