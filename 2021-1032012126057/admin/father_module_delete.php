<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';
$link=connect();
//验证管理员是否登录
include_once 'inc/is_admin_login_inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('father_module.php','error','id参数传递失败!');
}
$query="select * from son_module where father_module_id={$_GET['id']}";
$result=execute($link, $query);
if(mysqli_num_rows($result)){
    skip('father_module.php','error',"该学校部门下存在社团，请先清空社团！");
}

$query="delete from father_module where id={$_GET['id']}";
execute($link, $query);
if(mysqli_affected_rows($link)==1){
    skip('father_module.php','ok','恭喜您删除成功');
}else{
    skip('father_module.php','error','删除失败!请重试');
}
?>