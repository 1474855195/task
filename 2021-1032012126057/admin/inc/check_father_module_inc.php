<?php 
if(empty($_POST['module_name'])||empty($_POST['charger'])){
    skip('father_module_add.php','error','学校部门名称和负责人姓名不得为空！');
}
if(mb_strlen($_POST['module_name'],'utf-8')>255||mb_strlen($_POST['charger'],'utf-8')>255){
    skip('father_module_add.php','error','学校部门名称或负责人姓名过长！');
}
$_POST['module_name']=escape($link,$_POST['module_name']);
$_POST['charger']=escape($link,$_POST['charger']);
$query="select * from father_module where module_name='{$_POST['module_name']}'";
$result=execute($link,$query);
$query="select * from father_module where charger='{$_POST['charger']}'";
$result1=execute($link,$query);
$query="select id from father_module where id='{$_POST['id']}'";
$result2=execute($link,$query);
if(mysqli_num_rows($result) && mysqli_num_rows($result1)&& mysqli_num_rows($result2)){
    skip('father_module_add.php','error',"该记录已经存在，请重新输入！");
}
?>