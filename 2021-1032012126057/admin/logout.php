<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
if(!is_admin_login($link)){
    skip('father_module.php','ok','您还未登录，不需要注销');
}
session_unset();
session_destroy();
setcookie(session_name(),'',time()-1800,'/');
skip('login.php','ok','退出成功！');
?>
