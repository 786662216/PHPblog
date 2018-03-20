<meta charset="UTF-8">
<?php
/**
 * Created by PhpStorm.
 * User: 78666
 * Date: 2018/2/26
 * Time: 21:37
 */

//获取栏目id
$cat_id = $_GET['cat_id'];
//数据库操作
$conn = mysqli_connect('localhost','root','root');
mysqli_query($conn,'use blog');
mysqli_query($conn,'set names utf8');
//检测栏目id是否为数字
if(!is_numeric($cat_id)){
    echo '栏目不合法';
    exit();
}
//检测栏目是否存在
$sql = "select * from cat where cat_id=$cat_id";
$result = mysqli_query($conn,$sql);
if(mysqli_fetch_row($result)[0] == 0){
    echo '栏目不存在';
    exit();
}

//检测栏目下是否有文章
$sql2 = "select count(*) from art where cat_id=$cat_id";
$result2 = mysqli_query($conn,$sql2);
if(mysqli_fetch_row($result2)[0] != 0){
    echo '栏目下有文章，不能删除';
    exit();
}

//检测完毕，删除栏目
$sql3 = "delete from cat where cat_id = $cat_id";
if(!mysqli_query($conn,$sql3)){
    echo '栏目删除失败';
}else {
    echo "栏目删除成功";
}
?>