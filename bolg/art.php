<?php
/**
 * Created by PhpStorm.
 * User: 78666
 * Date: 2018/3/5
 * Time: 20:37
 */


include('./lib/init.php');

//查询所有分类
$sql = "select cat_id,catname from cat";
$cats = mGetAll($sql);


$art_id = $_GET['art_id'];
$sql = 'select title,content,pubtime,catname from art left join cat on art.cat_id=cat.cat_id where art_id='.$art_id;
$art = mGetRow($sql);
//print_r($art);

//如果地址栏输入一个没有的文章号 专跳到首页
if(empty($art)) {
    header('Location:index.php');
    exit;
}

//查询文章
$sql = 'select * from cat';
$cat = mGetAll($sql);

//查询所有的留言
$sql = "select * from comment where art_id=$art_id";
$comms = mGetAll($sql);

//post非空，则有留言
if(!empty($_POST)){
    $comm['nick'] = trim($_POST['nick']);
    $comm['email'] = trim($_POST['email']);
    $comm['content'] = trim($_POST['content']);
    $comm['pubtime'] = time();
    $comm['art_id']= $art_id;
    $comm['ip'] = sprintf('%u',ip2long(getRealIp()));
    $rs = mExec('comment',$comm);
    if($rs){
        //评论发布成功后，comm+1
        $sql = "update art set comm=comm+1 where art_id=$art_id";
        mQuery($sql);

        //跳转到上个页面
        $ref = $_SERVER['HTTP_REFERER'];
        header("location:$ref");
    }
}

include(ROOT.'/view/front/art.html');
?>