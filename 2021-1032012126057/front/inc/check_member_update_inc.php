<?php
if(empty($_POST['name'])){
    skip('register.php','error','姓名不得为空');
}
if(empty($_POST['sid'])){
    skip('register.php','error','学工号不得为空');
}
if(empty($_POST['dean'])){
    skip('register.php','error','学工号不得为空');
}
if(empty($_POST['tel'])){
    skip('register.php','error','学工号不得为空');
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