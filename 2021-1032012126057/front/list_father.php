<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
include_once 'inc/page_inc.php';
$link=connect();
$member_sid=is_login($link);
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('index.php','error','学校部门参数不合法！');
}
$query="select * from father_module where id={$_GET['id']}";
$result_father=execute($link, $query);
if(mysqli_num_rows($result_father)==0){
    skip('index.php','error','学校部门不存在！');
}
$data_father=mysqli_fetch_assoc($result_father);
$query="select * from son_module where father_module_id={$_GET['id']}";
$result_son=execute($link, $query);
$id_son='';
$son_list='';
while($data_son=mysqli_fetch_assoc($result_son)){
    $id_son.=$data_son['id'].',';
    $son_list.="<a href='list_son?id={$data_son['id']}'>{$data_son['module_name']}</a> ";
}
$id_son=trim($id_son,',');
if($id_son==''){
    $id_son='0';
}
$query="select count(*) from activity where module_id in ({$id_son})";
$count_all=num($link, $query);
$template['title']='社团所属学校部门';
$template['css']=array('style/public.css','style/list.css');
$page=page($count_all,5,8);//翻页函数
?>
<?php include_once 'inc/front_header_inc.php' ?>
<div id="position" class="auto">
		 <a href="index.php" style="color:#105cb6">首页</a> &gt; <a href="list_father?id=<?php echo $data_father['id'] ?>" style="color:#105cb6"><?php echo $data_father['module_name'] ?></a>
	</div>
	<div id="main" class="auto">
		<div id="left">
			<div class="box_wrap">
				<h3><?php echo $data_father['module_name'] ?></h3>
				<div class="num">
				    总活动数：<span><?php echo $count_all ?></span>
				  <div class="moderator"> 子版块： <?php echo $son_list ?></a></div>
				</div>
				<div class="pages_wrap">
				</div>
			</div>
			<div style="clear:both;"></div>
		<ul class="postsList">
			<?php 
			$query="select activity.id,son_module.module_name,activity.time,activity.title,activity.content,activity.num,activity.times
                 from activity,son_module where activity.module_id in ({$id_son}) 
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
		<a  href="publish.php?father_module_id=<?php echo $_GET['id'] ?>" target='_blank'>发布活动</a>
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