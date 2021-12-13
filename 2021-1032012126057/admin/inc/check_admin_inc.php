<?php
if(empty($_POST['name'])||empty($_POST['id'])||empty($_POST['pw'])){
    skip('admin_add.php','error','管理员用户名、密码不得为空！');
}
if(mb_strlen($_POST['name'],'utf-8')>32||mb_strlen($_POST['pw'],'utf-8')>32){
    skip('admin_add.php','error','管理员用户名或密码过长！');
}
$_POST['name']=escape($link,$_POST['name']);
$_POST['pw']=escape($link,$_POST['pw']);
$query="select * from admin where name='{$_POST['id']}'";
$result=execute($link,$query);
if(mysqli_num_rows($result)){
    skip('admin_add.php','error',"该记录已经存在，请重新输入！");
}
?>