<?php
if(empty($_POST['module_name'])||empty($_POST['son_charger'])){
    skip('son_module_add.php','error','社团名称和负责人姓名不得为空！');
}
if(mb_strlen($_POST['module_name'],'utf-8')>255||mb_strlen($_POST['son_charger'],'utf-8')>255||mb_strlen($_POST['info'],'utf-8')>255){
    skip('son_module_add.php','error','社团名称或负责人姓名或社团简介过长！');
}
if(!is_numeric($_POST['father_module_id'])){
    skip('son_module_add.php','error','社团所属部门不得为空！');
}
$_POST['module_name']=escape($link,$_POST['module_name']);
$_POST['son_charger']=escape($link,$_POST['son_charger']);
$query="select * from son_module where module_name='{$_POST['module_name']}'";
$result=execute($link,$query);
$query="select * from son_module where son_charger='{$_POST['son_charger']}'";
$result1=execute($link,$query);
$query="select * from son_module where father_module_id={$_POST['father_module_id']}";
$result2=execute($link,$query);
$query="select id from son_module where id={$_POST['id']}";
$result3=execute($link,$query);
$query="select * from son_module where member_id={$_POST['member_id']}";
$result4=execute($link,$query);
$query="select * from member where sid={$_POST['member_id']} and name='{$_POST['son_charger']}'";
$result5=execute($link,$query);
if(!mysqli_num_rows($result5)){
    skip('son_module_add.php','error',"负责人姓名学号输入错误！");
}
if(mysqli_num_rows($result) && mysqli_num_rows($result1) && mysqli_num_rows($result2) && mysqli_num_rows($result3) && mysqli_num_rows($result4)){
    skip('son_module_add.php','error',"该记录已经存在，请重新输入！");
}
?>