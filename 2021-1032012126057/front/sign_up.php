<?php 
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('index.php','error','id参数传递失败!');
}
$link=connect();
$query="select ac.num,ac.title,ac.content,ac.id,sc.name,ac.module_id,ac.time,ac.times from activity ac,son_charger sc where ac.id={$_GET['id']} and sc.mid=ac.module_id";
$result_activity=execute($link, $query);
$data_activity=mysqli_fetch_assoc($result_activity);
$query="update activity set times=times+1 where id={$_GET['id']}";
$result_times=execute($link, $query);
$data_activity['times']=$data_activity['times']+1;
$query="select * from activity_member where sid={$_COOKIE['member']['sid']} and activity_id={$_GET['id']}";
$result_activity_membr=execute($link, $query);
if(mysqli_num_rows($result_activity_membr)){
    skip('index.php','error','请不要重复报名');
}
$query="insert into activity_member(son_module_id,activity_id,activity_title,sid,name) values({$data_activity['module_id']},{$data_activity['id']},'{$data_activity['title']}',{$_COOKIE['member']['sid']},'{$_COOKIE['member']['name']}')";
execute($link, $query);
if(mysqli_affected_rows($link)==1){
    skip('index.php','ok',"恭喜您报名成功！");
}else{
    skip('index.php','error',"报名失败，请重试！");
}

?>