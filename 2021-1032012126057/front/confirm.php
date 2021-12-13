<?php
include_once '../inc/config_inc.php';
$_GET['message']=htmlspecialchars_decode($_GET['message']);
if(!isset($_GET['url'])||!isset($_GET['message'])||!isset($_GET['return_url']) ){
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>确认页面</title>
<meta name="keywords" content="确认页面" />
<meta name="description" content="确认页面" />
<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic ask"></span><?php echo $_GET['message'] ?><a style="color:red;" href="<?php echo $_GET['url'] ?>">确认</a> | <a style="color:green;" href="<?php echo $_GET['return_url'] ?>">取消</a></div>
</body>
</html>











