<?php
if(empty($_POST['module_id'])||!is_numeric($_POST['module_id'])){
    skip('publish.php','error','学号所属社团不合法！');
}
$query="select * from son_module where id={$_POST['module_id']}";
$result=execute($link, $query);
if(!mysqli_num_rows($result)){
    skip('publish.php','error','学号所属社团不存在！');
}
if(mb_strlen($_POST['title'],'utf-8')>50){
    skip('publish.php','error','标题不得超过50个字符！');
}
if(mb_strlen($_POST['content'],'utf-8')>999){
    skip('publish.php','error','活动简介不得超过999个字符！');
}



?>