<?php
function skip($url,$pic,$message){
    $html=<<<A
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="refresh" content="3;URL={$url} ?>"/>
<title>正在跳转中</title>
<meta name="keywords" content="跳转界面" />
<meta name="description" content="跳转界面" />
<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic {$pic}"></span>{$message}<a href="{$url}">3秒后自动跳转</a></div>
</body>
</html>
A;
    echo $html;
    exit;
}
//验证前台用户是否登录
function is_login($link){
    if(isset($_COOKIE['member']['sid'])&&isset($_COOKIE['member']['pw'])){
        $query="select * from member where sid='{$_COOKIE['member']['sid']}' and pw='{$_COOKIE['member']['pw']}'";
        $result=execute($link, $query);
        if(mysqli_num_rows($result)==1){
            $data=mysqli_fetch_assoc($result);
            return $data['sid'];
        }else {
            return false;
        }
    }else{
        return false;
    }
}
function check_user($member_sid,$activity_sid){
    if($member_sid==$activity_sid){
        return true;
    }else{
        return false;
    }
}
//验证管理员是否登录
function is_admin_login($link){
    if(isset($_SESSION['admin']['name'])&&isset($_SESSION['admin']['pw'])){
        $query="select * from admin where name='{$_SESSION['admin']['name']}' and pw='{$_SESSION['admin']['pw']}'";
        $result=execute($link, $query);
        if(mysqli_num_rows($result)==1){
            $data=mysqli_fetch_assoc($result);
            return $data['name'];
        }else {
            return false;
        }
    }else{
        return false;
    }
}
?>