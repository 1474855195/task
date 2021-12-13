<?php
if(!is_admin_login($link)){
    skip('login.php','error','请先登录在进行操作！');
}
?>