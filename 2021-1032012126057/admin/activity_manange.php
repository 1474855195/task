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
	<div class="title">活动列表</div>
	<table class="list">
		<tr>
			<th>名称</th>	 	 	
			<th>所属社团</th>
			<th>报名人数</th>
			<th>开始时间</th>
			<th>操作</th>
		</tr>
		<?php 
		$query="select ac.id,ac.title,sm.module_name,ac.times,ac.time from activity ac,son_module sm where ac.module_id=sm.id";
		$result=execute($link, $query);
		while($data=mysqli_fetch_assoc($result)){
		    $url=urlencode("activity_delete.php?id={$data['id']}");
		    $return_url=urlencode($_SERVER['REQUEST_URI']);
		    $message="你真的要删除{$data['title']}吗？";
		    $delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html=<<<A
    		 <tr>
    			<td>{$data['title']}</td>
    			<td>{$data['module_name']}</td>
    			<td>{$data['times']}</td>
                <td>{$data['time']}</td>
    			<td><a href="activity_member.php?id={$data['id']}">[导出名单]</a>&nbsp;&nbsp;<a href="activity_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href=$delete_url>[删除]</a></td>
    		</tr>
A;
            echo $html;
		}
		?>		
	</table>
</div>
<?php include 'inc/footer_inc.php' ?>	