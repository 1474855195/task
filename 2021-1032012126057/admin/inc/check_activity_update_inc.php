<?php
if(empty($_POST['title'])||empty($_POST['id'])||empty($_POST['module_id'])){
    skip('activity_manange.php','error','活动名称、活动序号、社团不得为空！');
}
if(mb_strlen($_POST['title'],'utf-8')>255){
    skip('activity_manange.php','error','活动名称过长！');
}
if(!is_numeric($_POST['module_id'])||!is_numeric($_POST['id'])){
    skip('activity_manange.php','error','id参数不合法');
}
$_POST['title']=escape($link,$_POST['title']);
$query="select * from activity where title='{$_POST['title']}'";
$result=execute($link,$query);
$query="select * from activity where module_id='{$_POST['module_id']}'";
$result1=execute($link,$query);
$query="select * from activity where content='{$_POST['content']}'";
$result2=execute($link,$query);
if(mysqli_num_rows($result) && mysqli_num_rows($result1)&& mysqli_num_rows($result2)){
    skip('activity_manange.php','error',"该记录已经存在，请重新输入！");
}
?>