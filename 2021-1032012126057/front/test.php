<?php 
header("Content-type:text/html;charset=utf-8");
/*
 参数说明：
 $count:总记录数
 $page_size:每页显示的记录数
 $num_btn:要显示的页码按钮
 $page:分页的get参数
 */
function page(&$count,$page_size,$num_btn=10,$page='page'){
    if(!isset($_GET[$page])||!is_numeric($_GET[$page])||$_GET[$page]<=1){
        $_GET[$page]=1;
    }
    //总页数
    $page_num_all=ceil($count/$page_size);
    if($_GET['page']>$page_num_all){
        $_GET[$page]=$page_num_all;
    }
    $start=($_GET[$page]-1)*$page_size;
    $limit="limit {$start},{$page_size}";
    $current_url=$_SERVER['REQUEST_URI'];//获取当前的url地址
    $arr_current=parse_url($current_url);//将当前url拆分到数组
    $current_path=$arr_current['path'];//将文件路径部分保存起来
    $url='';
    if(isset($arr_current['query'])){
        parse_str($arr_current['query'],$arr_query);
        unset($arr_query[$page]);
        if(empty($current_path)){
            $url="{$current_path}?{$page}=";
        }else{
           $other=http_build_query($arr_query);
           $url="{$current_path}?{$other}&{$page}=";
        }
    }else{
        $url="{$current_path}?{$page}=";
    }
    var_dump($url);
    $html=array();
    if($num_btn>=$page_num_all){
        for($i=1;$i<=$page_num_all;$i++){
            if($_GET[$page]==$i){
                $html[$i]="<span>{$i}</span>";
            }else{
                $html[$i]="<a href='{$url}{$i}'>{$i}</a>";
            }
        }
    }else{
        $num_left=floor(($num_btn-1)/2);
        $start_btn=$_GET[$page]-$num_left;
        $end_btn=$start_btn+$num_btn-1;
        if($start_btn<1){
            $start_btn=1;
        }
        if($end_btn>$page_num_all){
            $start_btn=$page_num_all-($num_btn-1);
        }
        for($i=0;$i<$num_btn;$i++){
            if($_GET[$page]==$start_btn){
                $html[$start_btn]="<span>{$start_btn}</span>";
            }else{
                $html[$start_btn]="<a href='{$url}{$start_btn}'>{$start_btn}</a>";
            }
            $start_btn++;
        }
        if(count($html)>=3){
            reset($html);
            $key_first=key($html);
            end($html);
            $key_end=key($html);
            if($key_first!=1){
                array_shift($html);
                array_unshift($html,"<a href='{$url}1'>1...</a>");
            }
            if($key_end!=$page_num_all){
                array_pop($html);
                array_push($html,"<a href='{$url}{$page_num_all}'>...{$page_num_all}</a>");
            }
        }       
    }
    if($_GET[$page]!=1){
        $prev=$_GET[$page]-1;
        array_unshift($html,"<a href='{$url}{$prev}'> <<上一页</a>");
    }
    if($_GET[$page]!=$page_num_all){
        $next=$_GET[$page]+1;
        array_push($html,"<a href='{$url}{$next}'>下一页>> </a>");
    }
    $html=implode(' ', $html);
    $data=array(
      'limit'=>$limit,
      'html'=>$html
    );
    return $data;
}
$a=105;
$page=page($a,5,8);
echo $page['html'];
?>