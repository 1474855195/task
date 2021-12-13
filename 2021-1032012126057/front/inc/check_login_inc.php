<?php
if(empty($_POST['sid'])){
    skip('login.php','error','学号不得为空');
}
if(mb_strlen($_POST['sid'],'utf-8')>32){
    skip('login.php','error','学号不得超过32个字符！');
}
if(empty($_POST['pw'])){
    skip('login.php','error','密码不得为空');
}
if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
    skip('login.php','error','验证码输入错误！');
}
escape($link, $_POST);
$query="select * from member where sid={$_POST['sid']}";
$result_name=execute($link, $query);
$data_name=mysqli_fetch_assoc($result_name);
setcookie('member[name]',$data_name['name'],time()+1800);
$query="select * from member where sid={$_POST['sid']} and pw=md5('{$_POST['pw']}')";
$result=execute($link, $query);
if(mysqli_num_rows($result)==1){
    setcookie('member[sid]',$_POST['sid']);
    setcookie('member[pw]',md5($_POST['pw']));
    skip('index.php','ok','登录成功');
}else{
    skip('login.php','error','学号或用户名输入错误！');
}
if(mysqli_num_rows($result)==1){
    skip('index.php','ok','登录成功');
}else{
    skip('login.php','error','学号或用户名输入错误！');
}
?>