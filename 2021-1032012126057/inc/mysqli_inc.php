<?php
//数据库连接
function connect($host=DB_HOST,$user=DB_USER,$password=DB_PASSWORD,$database=DB_DATABASE,$port=DB_PORT){
    $link=@mysqli_connect($host,$user,$password,$database,$port);
    if(mysqli_connect_errno()){
        exit(mysqli_connect_error());
    }
    mysqli_set_charset($link,'utf8');
    return $link;
}
//执行一条SQL语句，返回结果集对象或者返回布尔值
function execute($link,$query){
    $result=mysqli_query($link, $query);
    if(mysqli_errno($link)){
        exit(mysqli_error($link));
    }
    return $result;
}
//执行一条SQL查询，只返回布尔值
function execute_bool($link,$query){
    $bool=mysqli_real_query($link, $query);
    if(mysqli_errno($link)){
        exit(mysqli_error($link));
    }
    return $bool;
}
//一次性执行多次SQL语句
//第一个参数是连接、第二个参数是要输入的数组，第三个参数可用来查询错误，主函数测试代码如下：
/*$arr_sqls=array(
 'select * from father_module',
 'select * from father_module',
 'select * from father_module'
 );
 execute_multi($link, $arr_sqls, $error);
 echo $error;*/
function execute_multi($link,$arr_sqls,&$error){
    $sqls=implode(';', $arr_sqls).';';
    if($result=mysqli_multi_query($link,$sqls)){
        $data=array();
        $i=0;
        do{
            if($result=mysqli_store_result($link)){
                $data[$i]=mysqli_fetch_all($result);
                mysqli_free_result($result);
            }else{
                $data[i]=null;
            }
            $i++;
            if(!mysqli_more_results($link)) break;
        }while(mysqli_next_result($link));
        if($i==count($arr_sqls)){
            return $data;
        }else{
            $error="SQL语句执行失败：<br /> &nbsp; 数组下标为{$i}的语句：{$arr_sqls{$i}}&nbsp;执行错误<br />&nbsp;错误原因".mysqli_errno($link);
            return false;
            }
        }else{
            $error="SQL首条语句执行失败：<br /> &nbsp; 错误原因".mysqli_error($link);
            return false;
        }
    }
    //获取记录数
    //参数是linke连接，第二个参数是要查询的数量的sql语句
    function num($link,$sql_count){
        $result=execute($link,$sql_count);
        $count=mysqli_fetch_row($result);
        return $count[0];
    }
    
    //数据入库之前进行转义，确保数据能够顺利入库，举例参数如下
    /*$a=<<<hhsz
     ashjf;aa'djfa['''""\\
     hhsz;
     $data=array(
     0=>$a,
     1=>$a,
     2=>$a
     );*/
    function escape($link,$data){
        if(is_string($data)){
            return mysqli_real_escape_string($link, $data);
        }
        if(is_array($data)){
            foreach($data as $key=>$val){
                //在递归调用的是data和递归里面的data形式一样可以直接赋
                //如果$data是二维数组的话
                $data[$key]=escape($link, $val);
            }
        }
        return $data;
    }
    //关闭与数据库的连接
    /*但是由于这里的$link是形参，关闭的是形参的link，而不是原来的link，
     但是在php中如果向函数里面传递的是对象，
     那么并不是把对象赋值一份传给参数，而是直接传递过去，
     $link是一个对象，可以通过var_dump来查看*/
function close($link){
      mysqli_close($link);
}
    ?>