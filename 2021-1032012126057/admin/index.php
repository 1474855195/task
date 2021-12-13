<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
$query="select * from admin where id={$_SESSION['admin']['id']}";
$result_admin=execute($link, $query);
$data_admin=mysqli_fetch_assoc($result_admin);
$query="select count(*) from father_module";
$num_father=num($link, $query);
$query="select count(*) from son_module";
$num_son=num($link, $query);
$query="select count(*) from activity";
$num_activity=num($link, $query);
$query="select count(*) from admin";
$num_admin=num($link, $query);
$query="select count(*) from member";
$num_member=num($link, $query);
$template['title']='综合素质测评系统后台管理员界面';
$template['css']=array('style/public.css');
?>
<?php include 'inc/header_inc.php' ?>
<div id="main">
	<div class="title">系统信息</div>
	<div class="explain">
		<ul>
			<li>|- 您好，<?php echo $data_admin['name']?></li>
			<li>|- 创建时间：<?php echo $data_admin['register_time']?></li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|- 学校部门总数：<?php echo $num_father ?> 
				社团/教师总数：<?php echo $num_son ?>  
				活动总数：<?php echo $num_activity ?>  
				用户总数：<?php echo $num_member ?> 
				管理员<?php echo $num_admin ?>
			</li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|- 服务器操作系统：Windows </li>
			<li>|- 服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE']?> </li>
			<li>|- MySQL 版本：<?php echo mysqli_get_server_info($link)?></li>
			<li>|- 最大上传文件：<?php echo ini_get('upload_max_filesize')?></li>
			<li>|- 内存限制：<?php echo ini_get('memory_limit')?></li>
		</ul>
	</div>
	
	<div class="explain">
		<ul>
			<li>|- 程序安装位置(绝对路径)：<?php echo DB_PATH ?></li>
			<li>|- 程序在web根目录下的位置(首页的url地址)：/moral/</li>
			<li>|- 程序版本：moral V1.0 <a target="_blank" href="">[查看最新版本]</a></li>
			<li>|- 程序作者：苏浩 :)</li>
		</ul>
	</div>
</div>

<?php include 'inc/footer_inc.php' ?>