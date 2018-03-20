<?php
/**
 * Created by PhpStorm.
 * User: 78666
 * Date: 2018/3/4
 * Time: 14:01
 */

require ('./lib/init.php');

$sql = "select art_id,title,pubtime,comm,catname from art left join cat on art.cat_id=cat.cat_id";
$arts = mGetAll($sql);

include (ROOT.'/view/admin/artlist.html');


?>