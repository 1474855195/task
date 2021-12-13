<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
include_once 'inc/page_inc.php';
$link=connect();
$member_sid=is_login($link);
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('index.php','error','会员id参数不合法！');
}
$query="select * from member where id={$_GET['id']}";
$result_member=execute($link,$query);
if(mysqli_num_rows($result_member)!=1){
    skip('index.php','error','学号不存在！');
}
$data_member=mysqli_fetch_assoc($result_member);

$template['title']='用户列表';
$template['css']=array('style/public.css','style/list.css','style/member.css');
$query="select count(*) from activity_member where sid={$data_member['sid']}";
$count_all=num($link,$query);
$page=page($count_all,5,8);//翻页函数
?>
<?php include_once 'inc/front_header_inc.php' ?>
<div id="position" class="auto">
<a href="index.php">首页</a> &gt; 个人中心
</div>
<div id="main" class="auto">
	<div id="left">
		<ul class="postsList">
			<?php 
			$query="select * from activity_member where sid={$data_member['sid']} {$page['limit']}";
			$result_activity=execute($link,$query);
			while($data_activity=mysqli_fetch_assoc($result_activity)){   
			    $query="select * from son_module where id={$data_activity['son_module_id']}";
                $result_son_module=execute($link, $query);
                $data_son_module=mysqli_fetch_assoc($result_son_module);
                $query="select * from activity where id={$data_activity['activity_id']}";
                $result_info_activity=execute($link, $query);
                $data_info_activity=mysqli_fetch_assoc($result_info_activity);
			?>
			<li>
				<div class="smallPic">
						<img width="45" height="45" src="style/2374101_small.jpg?" />
				</div>
				<div class="subject">
					<div class="titleWrap"><a href="show.php?id=<?php echo $data_activity['activity_id']?>" target='_blank'><?php echo $data_activity['activity_title'] ?></a></div>
					<p>
					<?php 
					   if($member_sid){
					       $url="activity_resign.php?id={$data_activity['id']}";
					       $return_url=$_SERVER['REQUEST_URI'];
					       $message="你真的要取消报名{$data_activity['activity_title']}吗？";
					       $resign_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
					       echo "<a href='{$resign_url}'>取消报名";
					   }	
					?>
					</a> 主办方：<?php echo $data_son_module['module_name'] ?>&nbsp;<?php echo $data_info_activity['time'] ?>&nbsp;&nbsp;&nbsp;&nbsp;
					</p>
				</div>
				<div class="count">
					<p>
						总报名数<br /><span><?php echo $data_info_activity['times']?></span>
					</p>
					<p>
						浏览<br /><span><?php echo $data_info_activity['num']?></span>
					</p>
				</div>
				<div style="clear:both;"></div>
			</li>
			<?php }?>
		</ul>
		<div class="pages_wrap">
			<div class="pages">
				<?php 
				    echo $page['html'];
				?>
			</div>
		</div>
	</div>
	<div id="right">
		<div class="member_big">
			<dl>
				<dt>
					<img width="180" height="180" src="<?php if($data_member['photo']!=''){echo $data_member['photo'];}else{echo 'style/photo.jpg';}?>" />
				</dt>
				<dd class="name"><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data_member['name']?></dd>
				<dd>入学年份：<?php echo $data_member['year']?></dd>
				<dd>学院：<?php echo $data_member['dean']?></dd>
				<dd>报名活动总计：<?php echo $count_all; ?></dd>
				<dd><a target="_blank" href="member_update.php">修改信息</a></dd>
				<dd><a target="_blank" href="password_update.php">修改密码</a></dd>
			</dl>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php include_once 'inc/front_footer_inc.php' ?>