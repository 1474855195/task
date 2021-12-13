<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo $template['title'];?></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<?php 
foreach ($template['css'] as $val){
    echo "<link rel='stylesheet' type='text/css' href='{$val}' />";
}
?>
</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo">学生综合素质评测系统</div>
			<div class="nav">
				<a class="hover" href="index.php">首页</a>
			</div>
			<div class="serarch">
				<form action="search.php" method="get">
					<input class="keyword" type="text" name="keyword" placeholder="搜索" />
					<input class="submit" type="submit"  value="" />
				</form>
			</div>
			<div class="login">
			<?php 
			     if(isset($member_sid) && $member_sid){
			         $query="select id from member where sid={$member_sid}";
			         $result_sid=execute($link,$query);
			         $data_sid=mysqli_fetch_assoc($result_sid);
			         $str=<<<A
                           <a href='member.php?id={$data_sid['id']}'>个人中心</a>&nbsp;
			               <a href='logout.php'>退出</a>
A;
			         echo $str;
			     }else{
$str=<<<A
                           <a href="login.php">登录</a>&nbsp;
			               <a href="register.php">注册</a>
A;
		                   echo $str;
			     }
			?>
			</div>
		</div>
	</div>
	<div style="margin-top:55px;"></div>