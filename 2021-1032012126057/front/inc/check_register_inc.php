<?php
if(empty($_POST['name'])){
    skip('register.php','error','用户名不得为空');
}
if(empty($_POST['pw'])){
    skip('register.php','error','密码不得为空');
}
if(mb_strlen($_POST['name'],'utf-8')>32){
    skip('register.php','error','用户名不得超过32个字符！');
}
if(mb_strlen($_POST['pw'],'utf-8')<6){
    skip('register.php','error','密码不得少于6个字符！');
}
if($_POST['pw']!=$_POST['confirm_pw']){
    skip('register.php','error','两次输入的密码不一致！');
}
if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
    skip('register.php','error','验证码输入错误！');
}
$_POST=escape($link, $_POST);
$query="select * from member where sid={$_POST['sid']}";
$result=execute($link, $query);
if(mysqli_num_rows($result)==1){
    skip('register.php','error','该学号已经存在！');
}
?>