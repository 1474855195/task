<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('member_admin.php','error','id参数传递失败!');
}
$query="delete from member where id={$_GET['id']}";
execute($link, $query);
if(mysqli_affected_rows($link)==1){
    skip('member_admin.php','ok','恭喜您删除成功');
}else{
    skip('member_admin.php','error','删除失败!请重试');
}
?>