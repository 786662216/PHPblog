<?php
/**
 * Created by PhpStorm.
 * User: 78666
 * Date: 2018/3/4
 * Time: 19:45
 */

require ('./lib/init.php');

$art_id = $_GET['art_id'];

//判断art_id是否合法

if(!isset($art_id)){
    error('文章id不合法');
}

//是否有这篇文章
$sql = "select * from art where art_id=$art_id";
if(!mGetRow($sql)){
    error('文章不存在');
}

//删除文章
$sql = "delete from art where art_id=$art_id";
$re = mQuery($sql);
if(!$re){
    error('文章删除失败');
}else {
//    succ('文章删除成功');
//    sleep(3);
    header('location:artlist.php');
}











?>