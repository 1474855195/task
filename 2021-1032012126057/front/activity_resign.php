<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
$member_sid=is_login($link);
if(!$member_sid){
    skip('login.php','error','请先登录！');
}
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('index.php','error','活动id参数不合法！');
}
$query="select * from member where sid={$member_sid}";
$result_member=execute($link, $query);
$data_member=mysqli_fetch_assoc($result_member);
$query="select * from activity_member where id={$_GET['id']}";
$result_activity_member=execute($link, $query);
if(mysqli_num_rows($result_activity_member)==1){
    $data_activity_member=mysqli_fetch_assoc($result_activity_member);
    if(check_user($member_sid, $data_activity_member['sid'])){
        $query="delete from activity_member where id={$_GET['id']}";
        execute($link, $query);
        if(mysqli_affected_rows($link)==1){
            $query="update activity set times=times-1 where id={$data_activity_member['activity_id']}";
            execute($link, $query);
            skip("member.php?id={$data_member['id']}",'ok','取消成功！');
        }else{
            skip("member.php?id={$data_member['id']}}",'error','取消失败！');
        }
    }else{
        skip("member.php?id={$data_member['id']}}",'error','取消失败！');
    }
}else{
    skip('index.php','error','该活动不存在！');
}

?>