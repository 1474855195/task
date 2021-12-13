<?php 
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
$member_sid=is_login($link);
if(!$member_sid){
    skip('index.php','error','您还未登录，不需要退出!');
}
setcookie('member[name]','',time()-1800);
setcookie('member[sid]','',time()-1800);
skip('index.php','ok','退出成功！');
?>
