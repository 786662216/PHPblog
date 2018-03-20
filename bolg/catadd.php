<meta charset="utf-8">
<?php
/**
 * Created by PhpStorm.
 * User: 78666
 * Date: 2018/2/25
 * Time: 11:48
 */

require('./lib/init.php');

//判断表单是否有POST数据
if(empty($_POST)) {
    include(ROOT.'/view/admin/catadd.html');
} else {
//    //连接数据库
//    $conn = mysqli_connect('localhost','root','root');
//    mysqli_query($conn,'use blog');
//    mysqli_query($conn,'set names utf8');
    //检测蓝栏目是否为空
    $cat['catname'] = trim($_POST['catname']);
    if(empty($cat['catname'])){
        error('栏目不能为空');
        exit();
    }else{
        //栏目是否存在
        $sql1 = "select count(*) from cat where catname='$cat[catname]'";
        $result = mQuery($sql1);
        if(mysqli_fetch_row($result)[0] != 0){
            error('栏目已经存在');
            exit();
        //添加栏目
        }else{
//            //$sql2 = "insert into cat (catname) VALUE ('$cat[catname]')";
//            $result2 = mExec('cat',$cat);
//            if (!$result2){
//                // 成功执行SELECT, SHOW, DESCRIBE或 EXPLAIN查询会返回一个mysqli_result 对象,其余返回TURE，因为这里是inser into语句，所以成功返回了TURE
//                echo mysqli_error($conn);
//            }else{
//                echo '添加成功';
            $sql = "insert into cat (catname) values ('$cat[catname]')";
            $result = mysqli_query(mConn(),$sql);
            if(!$result){
                error('添加失败');
            } else {
                succ('栏目插入成功');
            }
            }
        }

}

?>