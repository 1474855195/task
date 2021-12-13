<?php
include_once '../inc/config_inc.php';
include_once '../inc/mysqli_inc.php';
include_once '../inc/tool_inc.php';

$link=connect();
$member_sid=is_login($link);

$template['title']='首页';
$template['css']=array('style/public.css','style/index.css');
?>

<?php include_once 'inc/front_header_inc.php' ?>

<?php 
$query="select * from father_module";
$result=execute($link, $query);
while($data_father=mysqli_fetch_assoc($result)){
?>
<div class="box auto">
        <div class="title">
    	     <a href="list_father?id=<?php echo $data_father['id'] ?>" style="color:#105cb6"><?php echo $data_father['module_name'] ?></a>
        </div>
        <div class="classList">
        <?php 
            $query="select * from son_module where father_module_id={$data_father['id']}";
            $result_son=execute($link, $query);
            if(mysqli_num_rows($result_son)){
                while($data_son=mysqli_fetch_assoc($result_son)){
                    $query="select count(*) from activity where module_id={$data_son['id']}";
                    $count_activity=num($link, $query);
                    $html=<<<A
                            <div class='childBox new'>
                            <h2><a href='list_son.php?id={$data_son['id']}'>{$data_son['module_name']}</a><span></span></h2>
                                                                                 可报名活动数：{$count_activity}<br />
                          </div>
A;
                    echo $html;
                }            
            }else {
                echo "<div style=pading:10px 0;>暂无下属社团</div>";
            }
        ?>
		<div style="clear:both;"></div>
	</div>
</div>
<?php } ?>
<?php include_once 'inc/front_footer_inc.php' ?>