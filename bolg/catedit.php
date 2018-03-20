<meta charset="utf-8">
<?php
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
if(empty($_POST)){
    //在输入框中显示之前的栏目名字
    $sql = "select catname from cat where cat_id=$cat_id";
    $result = mysqli_query($conn,$sql);
    $cat = mysqli_fetch_assoc($result);
    require ('./view/admin/catedit.html');
}else{
    //修改栏目
    $sql = "update cat set catname='$_POST[catname]' where cat_id=$cat_id";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        echo '栏目修改失败';
    }else{
        echo '栏目修改成功';
    }
}



?>