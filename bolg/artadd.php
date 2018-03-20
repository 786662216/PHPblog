<?php
/**
 * Created by PhpStorm.
 * User: 78666
 * Date: 2018/3/4
 * Time: 9:45
 */


require('./lib/init.php');

$sql = 'select * from cat';
$cats = mGetAll($sql);

if(empty($_POST)){
    include(ROOT. '/view/admin/artadd.html');
}else{
    //标题是否为空
    $art['title'] = trim($_POST['title']);
    if($art['title'] == ''){
        error('标题不能为空');
    }

    //检测栏目是否合法
    $art['cat_id'] = $_POST['cat_id'];
    if(!is_numeric($art['cat_id'])){
        error('栏目不合法');
    }

    //检测内容是否为空
    $art['content'] = trim($_POST['content']);
    if($art['content'] == ''){
        error('内容不能为空');
    }

    //插入发布时间
    $art['pubtime'] = time();

    //收集tag
    $art['arttag'] = trim($_POST['tag']);

    //写入数据库
    if(!mExec('art',$art)){
        error('文章发布失败');
    }else{
        //是否有tag
        $art['tag'] = trim($_POST['tag']);
        if($art['tag'] == ''){
            //将act表的num字段当前栏目下的文章数+1
            $sql = "update cat set num=num+1 where cat_id=$art[cat_id]";
            mQuery($sql);
            succ('文章添加成功');
        }else{
            //获取上次insert操作产生的主键id
            $art_id = getLastId();
            //插入tag到tag表
            $tag = explode(',',$art['tag']);//索引数组
            $sql = "insert into tag (art_id,tag) VALUES ";
            foreach($tag as $v){
                $sql .= "(".$art_id.",'".$v."') ,";
            }
            $sql = rtrim($sql,",");
            if(mQuery($sql)){
                //将act表的num字段当前栏目下的文章数+1
                $sql = "update cat set num=num+1 where cat_id=$art[cat_id]";
                mQuery($sql);
                succ('文章添加成功');
            }else{
                //tag添加失败,删除原文章
                $sql = "delete from art where art_id=$art_id";
                if(mQuery($sql)){
                    //将act表的num字段当前栏目下的文章数-1
                    $sql = "update cat set num=num-1 where cat_id=$art[cat_id]";
                    mQuery($sql);
                    error('文章添加失败');
                }

            }

        }
    }
}

?>