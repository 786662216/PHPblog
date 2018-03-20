<?php
/**
 * Created by PhpStorm.
 * User: 78666
 * Date: 2018/2/25
 * Time: 0:05
 */

require ('./lib/init.php');

//查询所有分类
$sql = "select cat_id,catname from cat";
$cats = mGetAll($sql);

//判断地址栏是否有catID,如果没有，显示所有文章；如果有，传给下面的sql语句，作为where条件过滤，以达到只显示特定栏目的目的
if(isset($_GET['cat_id'])){
    $where = " and cat.cat_id = $_GET[cat_id]";
} else {
    $where = '';
}

//分页代码
$sql = "select count(*) from  where 1" . $where;//获取总的文章数
$num = mGetOne($sql);//总的文章数
$curr = isset($_GET['page']) ? $_GET['page'] : 1;
$cnt = 2;//每页显示条数
$page = getPage($num,$curr,$cnt);

//查询所有的文章
$sql = "select art_id,title,content,pubtime,comm,catname from art inner join cat on art.cat_id=cat.cat_id where 1".$where.' order by art_id desc limit ' . ($curr-1)*$cnt . ',' . $cnt;
$arts = mGetAll($sql);

//如果当前栏目下没有文章，跳转到首页
//$sql = "select count(*) from art where cat_id = $cats[cat_id]";
//if(mysqli_query(mConn(),$sql) == 0){
//    header('location:index.php');
//}

require (ROOT . './view/front/index.html');

?>