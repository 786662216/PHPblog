<meta charset="utf8">
<?php
/**
 * Created by PhpStorm.
 * User: 78666
 * Date: 2018/2/26
 * Time: 15:58
 */
//数据库操作
$conn = mysqli_connect('localhost','root','root');
mysqli_query($conn,'use blog');
mysqli_query($conn,'set names utf8');
//取出所有的文章栏目
$sql = 'select * from cat';
$rs =mysqli_query($conn,$sql);
$cat = array();
while($row = mysqli_fetch_assoc($rs)){
    $cat[] = $row;
}
include('lib/init.php');
include('./view/admin/catlist.html');
?>