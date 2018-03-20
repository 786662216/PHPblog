<?php
/**
 * Created by PhpStorm.
 * User: 78666
 * Date: 2018/2/28
 * Time: 21:00
 */

/*
 * 当操作成功时的提示信息
 *
 *
 *
 * */

function succ($res){
    $result = 'succ';
    require(ROOT.'/view/admin/info.html');
    exit();
}
/*
 *
 * 当操作失败是的提示信息
 *
 *
 * */

function error($res){
    $result = 'fail';
    require(ROOT.'/view/admin/info.html');
    exit();
}

/*
 *
 *
 * 获取来访者的真实ip
 *
 *
 *
 */

function getRealIp(){
    static $realip = null;
    if($realip !== null){
        return $realip;
    }

    if(getenv('REMOTE_ADDR')){
        $realip = getenv('REMOTE_ADDR');
    }else if(getenv('HTTP_CLIENT_IP')){
        $realip = getenv('HTTP_CLIENT_IP');
    }else if(getenv('HTTP_X_FROWARD_FOR')){
        $realip = getenv('HTTP_X_FROWARD_FOR');
    }

    return $realip;
}

/*
 * 生成分页码
 * param int $num 文章总数
 * param int $curr 当前显示的页码数
 * param int $cnt 每页显示的条数
 *
 */

function getPage($num,$curr,$cnt){
    //最大的页码数
    $max = ceil($num/$cnt);
    //最左侧页码
    $left = max(1 , $curr-2);
    //最右侧页码
    $right = min($left + 4, $max);

    $page = array();
    for($i=$left;$i<=$right;$i++){
        $_GET['page'] = $i;
        $page[$i] = http_build_query($_GET);
    }
    return $page;
}








?>