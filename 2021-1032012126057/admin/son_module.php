<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
$template['title']='社团列表界面';
$template['css']=array('style/public.css');
?>
<?php include 'inc/header_inc.php' ?>
<div id="main" >
	<div class="title">社团列表</div>
	<table class="list">
		<tr>
			<th>序号</th>	 	 	
			<th>所属学校部门</th>
			<th>社团名称</th>
			<th>负责人学工号</th>
			<th>负责人</th>
			<th>操作</th>
		</tr>
		<?php 
		$query="select sm.id,sm.module_name,fm.module_name fmodule_name,sm.member_id,sm.son_charger from son_module sm,father_module fm where sm.father_module_id=fm.id order by fm.id";
		$result=execute($link, $query);
		while($data=mysqli_fetch_assoc($result)){
		    $url=urlencode("son_module_delete.php?id={$data['id']}");
		    $return_url=urlencode($_SERVER['REQUEST_URI']);
		    $message="你真的要删除{$data['module_name']}吗？";
		    $delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html=<<<A
    		 <tr>
    			<td>{$data['id']}</td>
    			<td>{$data['fmodule_name']}</td>
    			<td>{$data['module_name']}</td>
                <td>{$data['member_id']}</td>
                <td>{$data['son_charger']}</td>
    			<td><a href="son_module_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href=$delete_url>[删除]</a></td>
    		</tr>
A;
            echo $html;
		}
		?>		
	</table>
</div>
<?php include 'inc/footer_inc.php' ?>	
