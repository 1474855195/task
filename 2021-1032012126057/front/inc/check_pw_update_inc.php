<?php
if(mb_strlen($_POST['pw'],'utf-8')<6){
    skip('password_update.php','error','密码不得少于6个字符！');
}
if($_POST['pw']!=$_POST['confirm_pw']){
    skip('password_update.php','error','两次输入的密码不一致！');
}
if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
    skip('password_update.php','error','验证码输入错误！');
}
if($_POST['sid']!=$member_sid){
    skip('password_update.php','error','学号输入错误！');
}
$_POST=escape($link, $_POST);
$query="select * from member where sid={$_POST['sid']}";
$result=execute($link, $query);
if(mysqli_num_rows($result)!=1){
    skip('password_update.php','error','该学号不存在！');
}
?>