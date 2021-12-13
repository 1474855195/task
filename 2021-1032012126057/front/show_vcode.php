<?php
session_start();
include_once '../inc/vcode_inc.php';
$_SESSION['vcode']=vcode();
?>