<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo $template['title'];?></title>
<meta name='keywords' content='后台界面' />
<meta name='description' content='后台界面' />
<?php 
foreach ($template['css'] as $val){
    echo "<link rel='stylesheet' type='text/css' href='{$val}' />";
}
?>
</head>
<body>
	<div id="top">
		<div class="logo">
			学生综合素质评测系统
		</div>
		<ul class="nav">
			<li><a href=# target="_blank"></a></li>
			<li><a href=# target="_blank"></a></li>
		</ul>
		<div class="login_info">
			<a href="../front/index.php" style="color:#fff;">网站首页</a>&nbsp;|&nbsp;
			管理员： <?php $name=is_admin_login($link);echo $name ?> <a href="logout.php">[注销]</a>
		</div>
	</div>
	<div id="sidebar">
		<ul>
			<li>
				<div class="small_title">系统</div>
				<ul class="child">
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='index.php'){ echo "class=current";}?> href="index.php">系统信息</a></li>
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='admin.php'){ echo "class=current";}?> href="admin.php">管理员列表</a></li>
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='admin_add.php'){ echo "class=current";}?> href="admin_add.php">管理员添加</a></li>
				</ul>
			</li>
			<li><!--  class="current" -->
				<div class="small_title">成员管理</div>
				<ul class="child">
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module.php'){ echo "class=current";}?> href="father_module.php">学校部门列表</a></li>
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module_add.php'){ echo "class=current";}?> href="father_module_add.php">学校部门添加</a></li>
					<?php 
					if(basename($_SERVER['SCRIPT_NAME'])=='father_module_update.php'){
					    echo '<li><a class=current>学校部门编辑</a></li>';
					}
					?>
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='son_module.php'){ echo "class=current";}?> href="son_module.php">社团列表</a></li>
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='son_module_add.php'){ echo "class=current";}?> href="son_module_add.php">社团添加</a></li>
					<?php 
					if(basename($_SERVER['SCRIPT_NAME'])=='son_module_update.php'){
					    echo '<li><a class=current>社团信息编辑</a></li>';
					}
					?>
					
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='activity_manange.php'){ echo "class=current";}?> href="activity_manange.php">活动管理</a></li>
					<?php 
					if(basename($_SERVER['SCRIPT_NAME'])=='activity_update.php'){
					    echo '<li><a class=current>活动信息编辑</a></li>';
					}
					?>
					<?php 
					if(basename($_SERVER['SCRIPT_NAME'])=='activity_member.php'){
					    echo '<li><a class=current>名单导出</a></li>';
					}
					?>
				</ul>
			</li>
			<li>
				<div class="small_title">用户管理</div>
				<ul class="child">
					<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='member_admin.php'){ echo "class=current";}?> href="member_admin.php">学生列表</a></li>
				</ul>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='son_module_teacher.php'){ echo "class=current";}?> href="son_module_teacher.php">教师列表</a></li>
					<?php 
					if(basename($_SERVER['SCRIPT_NAME'])=='son_module_teacher_update.php'){
					    echo '<li><a class=current>教师信息编辑</a></li>';
					}
					?>
			</li>
		</ul>
	</div>
	
	
	
	