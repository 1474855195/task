<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
include_once 'inc/page_inc.php';
$link=connect();
$member_sid=is_login($link);
if(!isset($_GET['keyword'])){
    $_GET['keyword']='';
}
$_GET['keyword']=trim($_GET['keyword']);
$_GET['keyword']=escape($link,$_GET['keyword']);
$query="select count(*) from activity where title like '%{$_GET['keyword']}%'";
$count_all=num($link, $query);
$template['title']='搜索页';
$template['css']=array('style/public.css','style/list.css');
$page=page($count_all,5,8);//翻页函数
?>
<?php include_once 'inc/front_header_inc.php' ?>
<div id="position" class="auto">
		 <a href="index.php" style="color:#105cb6">首页</a> &gt; 搜索页
	</div>
	<div id="main" class="auto">
		<div id="left">
			<div class="box_wrap">
				<h3>共搜索到<?php echo $count_all ?>条相关记录</h3>
				<div class="pages_wrap">
					<div style="clear:both;"></div>
		</div>
	</div>
	<div style="clear:both;"></div>
	<ul class="postsList">
		<?php 
		$query="select activity.id,son_module.module_name,activity.time,activity.title,activity.content,activity.num,activity.times
		from activity,son_module where title like '%{$_GET['keyword']}%' 
		and activity.module_id=son_module.id {$page['limit']}";
		$result_activity=execute($link, $query);
		while($data_activity=mysqli_fetch_assoc($result_activity)){
		    $data_activity['title']=htmlspecialchars_decode($data_activity['title']);
		    $data_activity['content']=nl2br(htmlspecialchars_decode($data_activity['content']));			   
		?>
		<li>
				<div class="smallPic">
						<img width="45" height="45"src="style/2374101_small.jpg">
				</div>
				<div class="subject">
					<div class="titleWrap"><a href="show.php?id=<?php echo $data_activity['id']?>" target='_blank'><?php echo $data_activity['title'] ?></a></div>
					<p>
						主办方：<?php echo $data_activity['module_name'] ?>&nbsp;<?php echo $data_activity['time'] ?>&nbsp;&nbsp;&nbsp;&nbsp;
					</p>
				</div>
				<div class="count">
					<p>
						报名<br /><span><?php echo $data_activity['times']?></span>
					</p>
					<p>
						浏览<br /><span><?php echo $data_activity['num']?></span>
					</p>
				</div>
				<div style="clear:both;"></div>
			</li>	
		<?php 
		      }
		?>
	</ul>
	<div class="pages_wrap">
		<div class="pages">
		<?php 
		      echo $page['html'];
		?>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>
<div id="right">
		<div class="classList">
			<div class="title">版块列表</div>
			<ul class="listWrap">
				<?php 
			    $query="select * from father_module";
			    $result_father1=execute($link, $query);
			    while($data_father1=mysqli_fetch_assoc($result_father1)){		        
			?>
			<li>
				<h2><a href="list_father?id=<?php echo $data_father1['id'] ?>"><?php echo $data_father1['module_name']?></a></h2>
				<ul>
					<?php 
				       $query="select * from son_module where father_module_id={$data_father1['id']}";
				       $result_son1=execute($link, $query);
				       while($data_son1=mysqli_fetch_assoc($result_son1)){ 
				     ?>
				    <li><h3><a href="list_son.php?id=<?php echo $data_son1['id'] ?>"><?php echo $data_son1['module_name'] ?></a></h3></li>
					<?php 
				       }
					?>
				</ul>
			</li>
			<?php 
			}
			?>
		</ul>
	</div>
</div>
<div style="clear:both;"></div>
</div>
<?php include_once 'inc/front_footer_inc.php' ?>