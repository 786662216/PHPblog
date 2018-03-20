<meta charset="UTF-8">
<?php

/**
 *
 * 连接数据库，返回数据库
 *
 * return连接好的数据库
*/

function mConn(){
    static $conn = null;
    $cfg = require (ROOT.'/lib/config.php');
    if($conn === null){
        $conn = mysqli_connect($cfg['host'],$cfg['user'],$cfg['pwd']);
        mysqli_query($conn,'use ' . $cfg['db']);
        mysqli_query($conn,'set names '.$cfg['charset']);
    }
    return $conn;
}

/**
 * 查询的函数
 * param
 * return mixed resource/bool
 *
 */

function mQuery($sql){
    $result = mysqli_query(mConn(),$sql);
    if($result){
        mLog($sql);
    }else{
        mLog($sql."\n".mysqli_error(mConn()));
    }
    return $result;
}

/* log日志记录功能
 * param str $str 待记录的字符串
 *
 *
 *
 *
 * */

function mLog($str){
    $filename = ROOT .'/log/'.@date('Ymd').'.txt';
    $log = "-----------------------------------------------\n" .@date('Y/m/d H:i:s')."\n".$str."\n"."-----------------------------------------------\n\n";
    return file_put_contents($filename,$log,FILE_APPEND);
}

/**
 *
 *
 * selelct 查询返回二维数据
 * param str $sql select 待查询的sql语句
 * return mixed select查询成功，返回二维数组，失败返回false
 */

function mGetAll($sql){
    $result = mQuery($sql);
    if(!$result){
        return false;
    }

    $data = array();

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    return $data;
}

/*
 * select取出一行数据
 *
 * param str $sql 待查询的SQL语句
 * return array/false 查询成功 返回一个一维数组
 */

function mGetRow($sql){
    $result = mQuery($sql);
    if(!$result){
        return false;
    }
    return mysqli_fetch_assoc($result);
}

/**
 * select 返回一个结果
 * param $sql 待查询的select语句
 * return mixed 成功返回结果，是啊比返回false
 *
 */

function mGetOne($sql){
    $result = mQuery($sql);
    if(!$result){
        return false;
    }
    return mysqli_fetch_row($result)[0];
}

/**
 *
 *自动拼接inser 和 update sql语句，并且调用mQuert()去执行sql语句
 *
 *param str $tables 表名
 *param arr $data 接受到的数据，是一个一维数组,键为列名，值为插入值
 *param str $act 动作，默认为insert
 * param str $where 防止update更改时少加where条件
 * return boll insert 或者update插入成功或失败
 */

function mExec($table,$data,$act='insert',$where = 0){
    if($act == 'insert'){
        $sql = "insert into $table (";
        $sql .= implode(',',array_keys($data)).") values ('";
        $sql .= implode("','",array_values($data)) ."')";
        //echo $sql;
        return mQuery($sql);
    }else if ($act == 'update'){
        $sql = "update $table set ";
        foreach($data as $key=>$value){
            $sql .=  $key . "='" . $value ."',";
        }
        $sql = rtrim($sql,','). " where " . $where;
        //echo $sql;
        return mQuery($sql);
    }
}

/**
 *
 * 取得上一步insert操作产生的主键ID
 *
 *
 */

function getLastId(){
    return mysqli_insert_id(mConn());
}
?>