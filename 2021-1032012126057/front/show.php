<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
$member_sid=is_login($link);
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('index.php','error','活动id参数不合法！');
}
$query="select ac.num,ac.title,ac.content,ac.id,sc.name,ac.module_id,ac.time from activity ac,son_charger sc where ac.id={$_GET['id']} and sc.mid=ac.module_id";
$result_activity=execute($link, $query);
if(mysqli_num_rows($result_activity)!=1){
    skip('index.php','error','活动不存在！');
}
$query="update activity set num=num+1 where id={$_GET['id']}";
execute($link, $query);
$data_activity=mysqli_fetch_assoc($result_activity);
$data_activity['num']=$data_activity['num']+1;
$data_activity['title']=htmlspecialchars_decode($data_activity['title']);
$data_activity['content']=nl2br(htmlspecialchars_decode($data_activity['content']));
$query="select * from son_module where id={$data_activity['module_id']}";
$result_son=execute($link, $query);
$data_son=mysqli_fetch_assoc($result_son);
$query="select * from father_module where id={$data_son['father_module_id']}";
$result_father=execute($link, $query);
$data_father=mysqli_fetch_assoc($result_father);

$template['title']='活动介绍界面';
$template['css']=array('style/public.css','style/show.css');
?>
<?php include_once 'inc/front_header_inc.php' ?>
<div id="position" class="auto">
		 <a href='index.php' style="color:#105cb6">首页</a> &gt; <a href="list_father?id=<?php echo $data_father['id'] ?>" style="color:#105cb6"><?php echo $data_father['module_name'] ?></a> &gt; <a href="list_son?id=<?php echo $data_son['id'] ?>"style="color:#105cb6"><?php echo $data_son['module_name'] ?></a> &gt; <?php echo $data_activity['title'] ?>
	</div>
	<div id="main" class="auto">
		<div class="wrap1">
		</div>
		<div class="wrapContent">
			<div class="right">
				<div class="title">
					<h2><?php echo $data_activity['title']?></h2>
					<span>浏览：<?php echo $data_activity['num']?>&nbsp;</span>
					<div style="clear:both;"></div>
			</div>
			<div class="pubdate">
				<span class="date">发布于：<?php echo $data_activity['time']?> </span>
				<span class="floor" style="color:red;font-size:14px;font-weight:bold;"></span>
			</div>
			<div class="content">
				 <?php echo $data_activity['content']?>
			</div>
			<span class="date" style="color:#105cb6">截止时间：发布后一周内 </span><br />
			<?php 
			$url="sign_up.php?id={$data_activity['id']}";
			$return_url=$_SERVER['REQUEST_URI'];
			$message="你真的要报名{$data_activity['title']}吗？";
			$signup_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
			echo "<a  href={$signup_url} target='_blank' style='font-size:20px'>报名</a>";
			?>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>
<?php include_once 'inc/front_footer_inc.php' ?>